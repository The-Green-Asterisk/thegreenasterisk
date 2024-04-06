<?php

namespace App\Http\Controllers;

use App\Mail\ErrorMail;
use App\Models\User;
use Http;
use Mail;
use Twitter;

class SocialController extends Controller
{
    public function getTwitterFeed()
    {
        //deprecated -- if you go back to using "X", check out their new protocols.
        $tweets = Twitter::userTweets(9896162, ['max_results' => 25, 'expansions' => 'attachments.media_keys', 'tweet.fields' => 'created_at', 'media.fields' => 'preview_image_url,url', 'response_format' => 'object']);

        //if there's an error, email me
        if (isset($tweets->errors)) {
            $error = '';
            foreach ($tweets->errors as $e) {
                $error .= $e->message;
            }
            $error .= ' - '.json_encode($tweets);
            Mail::to(config('app.admin_email'))->send(new ErrorMail($error));

            return [];
        }

        //convert urls to links
        foreach ($tweets->data as $tweet) {
            $tweet->text = preg_replace('/(https?:\/\/[^\s]+)/', '<a href="$1" target="_blank">$1</a>', $tweet->text);
        }

        //convert hashtags to links
        foreach ($tweets->data as $tweet) {
            $tweet->text = preg_replace('/#([a-zA-Z0-9_]+)/', '<a href="https://twitter.com/hashtag/$1" target="_blank">#$1</a>', $tweet->text);
        }

        //convert @ to follow link
        foreach ($tweets->data as $tweet) {
            $tweet->text = preg_replace('/@([a-zA-Z0-9_.]{1,15})\b/', '<a href="https://twitter.com/$1" target="_blank">@$1</a>', $tweet->text);
        }

        foreach ($tweets->data as $tweet) {
            if (isset($tweets->includes) && isset($tweet->attachments)) {
                foreach ($tweets->includes->media as $pic) {
                    if (in_array($pic->media_key, $tweet->attachments->media_keys)) {
                        $image_url = isset($pic->preview_image_url) ? $pic->preview_image_url : $pic->url;
                    }
                }
            }
            $tweets->includes->media;
            $posts[] = [
                'type' => 'Twitter',
                'message' => $tweet->text,
                'timestamp' => $tweet->created_at,
                'url' => 'https://twitter.com/lordsteve/status/'.$tweet->id,
                'image' => $image_url ?? null,
                'is_video' => false,
            ];

            $image_url = null;
        }

        return $posts;
    }

    public function getFacebookFeed()
    {
        //get new access token from here: https://developers.facebook.com/tools/explorer/
        $user = User::where('name', 'Steve Beaudry')->whereNotNull('facebook_account')->first();

        $fbRequest = json_decode(Http::get('https://graph.facebook.com/oauth/access_token?grant_type=fb_exchange_token&client_id='.config('services.facebook.client_id').'&client_secret='.config('services.facebook.client_secret').'&fb_exchange_token='.$user->login_service_token));

        if (isset($fbRequest->error)) {
            $error = '';
            foreach ($fbRequest->error as $e) {
                $error .= $e;
            }
            $error .= ' - '.json_encode($fbRequest).' - This probably means you should re-login using Facebook.';
            Mail::to(config('app.admin_email'))->send(new ErrorMail($error));

            return [];
        }

        $fbPosts = json_decode(Http::get(
            'https://graph.facebook.com/v15.0/me?fields=id,name,posts%7Bcreated_time%2Cpermalink_url%2Cfull_picture%2Cmessage%7D&access_token='
            .$fbRequest->access_token
        ));

        $pagePosts = json_decode(Http::get(
            'https://graph.facebook.com/v15.0/me?fields=id,name,posts%7Bcreated_time%2Cpermalink_url%2Cfull_picture%2Cmessage%7D&access_token='
            .config('services.facebook.page_access_token')
        ));

        if (isset($fbPosts->posts->data) && isset($pagePosts->posts->data)) {
            $fbPosts->posts->data = array_merge($fbPosts->posts->data, $pagePosts->posts->data);
        }

        //if there's an error, email me
        if (isset($fbPosts->error) || isset($pagePosts->error)) {
            $error = '';
            if (isset($fbPosts->error)) {
                foreach ($fbPosts->error as $e) {
                    $error .= $e;
                }
            }
            if (isset($pagePosts->error)) {
                foreach ($pagePosts->error as $e) {
                    $error .= $e;
                }
            }
            $error .= ' - '.json_encode($fbPosts).json_encode($pagePosts);
            Mail::to(config('app.admin_email'))->send(new ErrorMail($error));

            if (isset($fbPosts->error) && isset($pagePosts->error)) return [];
        }

        //convert urls to links
        if (isset($fbPosts->posts)) foreach ($fbPosts->posts->data as $post) {
            if (isset($post->message)) {
                $post->message = preg_replace('/(https?:\/\/[^\s]+)/', '<a href="$1" target="_blank">$1</a>', $post->message);
            }
        }

        //convert hashtags to links
        if (isset($fbPosts->posts)) foreach ($fbPosts->posts->data as $post) {
            if (isset($post->message)) {
                $post->message = preg_replace('/#([a-zA-Z0-9_.]+)/', '<a href="https://www.facebook.com/hashtag/$1" target="_blank">#$1</a>', $post->message);
            }
        }

        if (isset($fbPosts->posts)) foreach ($fbPosts->posts->data as $post) {
            $posts[] = [
                'type' => 'Facebook',
                'message' => isset($post->message) ? $post->message : null,
                'timestamp' => isset($post->created_time) ? $post->created_time : null,
                'url' => isset($post->permalink_url) ? $post->permalink_url : null,
                'image' => isset($post->full_picture) ? $post->full_picture : null,
                'is_video' => false,
            ];
        }

        return isset($posts) ? $posts : [];
    }

    public function getInstagramFeed()
    {
        //get new access token here: https://developers.facebook.com/apps/898519577943965/instagram-basic-display/basic-display/

        $ig = Http::get('https://graph.instagram.com/me/media?fields=id,caption,media_type,username,media_url,timestamp,permalink&access_token='.config('services.instagram.access_token'));

        $ig = json_decode($ig);

        //if there's an error, email me
        if (isset($ig->error)) {
            $error = '';
            foreach ($ig->error as $e) {
                $error .= $e;
            }
            $error .= ' - '.json_encode($ig);
            Mail::to(config('app.admin_email'))->send(new ErrorMail($error));

            return [];
        }

        //turn hashtags into links
        foreach ($ig->data as $post) {
            if (isset($post->caption)) {
                $post->caption = preg_replace('/#([a-zA-Z0-9_.]+)/', '<a href="https://www.instagram.com/explore/tags/$1" target="_blank">#$1</a>', $post->caption);
            }
        }

        //turn @ into links
        foreach ($ig->data as $post) {
            if (isset($post->caption)) {
                $post->caption = preg_replace('/@([a-zA-Z0-9_.]{1,30})\b/', '<a href="https://www.instagram.com/$1" target="_blank">@$1</a>', $post->caption);
            }
        }

        foreach ($ig->data as $post) {
            $posts[] = [
                'type' => 'Instagram',
                'message' => isset($post->caption) ? $post->caption : null,
                'timestamp' => $post->timestamp,
                'url' => $post->permalink,
                'image' => $post->media_url,
                'is_video' => $post->media_type == 'VIDEO',
            ];
        }

        return $posts;
    }

    public function buildFeed()
    {
        // $twitter = $this->getTwitterFeed();
        $facebook = $this->getFacebookFeed();
        $instagram = $this->getInstagramFeed();

        $feed = array_merge($facebook, $instagram);

        //sort feed by timestamp
        usort($feed, function ($a, $b) {
            return strtotime($b['timestamp']) - strtotime($a['timestamp']);
        });

        return $feed;
    }

    public function index()
    {
        $social_posts = $this->buildFeed();

        return view('components.social-feed', compact('social_posts'));
    }
}
