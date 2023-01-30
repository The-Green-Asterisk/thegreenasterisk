<?php

namespace App\Http\Controllers;

use Http;
use Twitter;

class SocialController extends Controller
{
    public function getTwitterFeed()
    {
        $tweets = Twitter::userTweets(9896162, ['max_results' => 25, 'expansions' => 'attachments.media_keys', 'tweet.fields' => 'created_at', 'media.fields' => 'preview_image_url,url', 'response_format' => 'object']);

        //if there's an error, email me
        if (isset($tweets->errors)) {
            $error = '';
            foreach ($tweets->errors as $e) {
                $error .= $e->message;
            }
            $error .= ' - '.json_encode($tweets);
            mail(config('app.admin_email'), 'Twitter Error', $error);

            return [];
        }

        //convert urls to links
        foreach ($tweets->data as $tweet) {
            $tweet->text = preg_replace('/(https?:\/\/[^\s]+)/', '<a href="$1" target="_blank">$1</a>', $tweet->text);
        }

        //convert hashtags to links
        foreach ($tweets->data as $tweet) {
            $tweet->text = preg_replace('/#([^\s]+)/', '<a href="https://twitter.com/hashtag/$1" target="_blank">#$1</a>', $tweet->text);
        }

        //convert @ to follow link
        foreach ($tweets->data as $tweet) {
            $tweet->text = preg_replace('/@([^\s]+)/', '<a href="https://twitter.com/$1" target="_blank">@$1</a>', $tweet->text);
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
        //get new temporary access token from here: https://developers.facebook.com/tools/explorer/
        // $token = Http::get('https://graph.facebook.com/oauth/access_token?grant_type=fb_exchange_token&client_id='.config('services.facebook.client_id').'&client_secret='.config('services.facebook.client_secret').'&fb_exchange_token={{{insert Temporary Access Token}}}'));
        $fbPosts = Http::get('https://graph.facebook.com/v15.0/me?fields=id,name,posts{full_picture,message,link,permalink_url,created_time}&access_token='.config('services.facebook.access_token'));

        // $pagePosts = Http::get('https://graph.facebook.com/v15.0/LordSteve?fields=id,name,posts{full_picture,message,link,permalink_url,created_time}&access_token='.config('services.facebook.access_token'));

        $fbPosts = json_decode($fbPosts);
        // $pagePosts = json_decode($pagePosts);

        // dd($pagePosts);

        // $fbPosts->posts->data = array_merge($fbPosts->posts->data, $pagePosts->posts->data);

        //if there's an error, email me
        if (isset($fbPosts->error)) {
            $error = '';
            foreach ($fbPosts->error as $e) {
                $error .= $e->message;
            }
            $error .= ' - '.json_encode($fbPosts);
            mail(config('app.admin_email'), 'Facebook Error', $error);

            return [];
        }

        //convert urls to links
        foreach ($fbPosts->posts->data as $post) {
            if (isset($post->message)) {
                $post->message = preg_replace('/(https?:\/\/[^\s]+)/', '<a href="$1" target="_blank">$1</a>', $post->message);
            }
        }

        //convert hashtags to links
        foreach ($fbPosts->posts->data as $post) {
            if (isset($post->message)) {
                $post->message = preg_replace('/#([^\s]+)/', '<a href="https://www.facebook.com/hashtag/$1" target="_blank">#$1</a>', $post->message);
            }
        }

        foreach ($fbPosts->posts->data as $post) {
            $posts[] = [
                'type' => 'Facebook',
                'message' => isset($post->message) ? $post->message : null,
                'timestamp' => $post->created_time,
                'url' => $post->permalink_url,
                'image' => isset($post->full_picture) ? $post->full_picture : null,
                'is_video' => false,
            ];
        }

        return $posts;
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
                $error .= $e->message;
            }
            $error .= ' - '.json_encode($ig);
            mail(config('app.admin_email'), 'Instagram Error', $error);

            return [];
        }

        //turn hashtags into links
        foreach ($ig->data as $post) {
            if (isset($post->caption)) {
                $post->caption = preg_replace('/#([^\s]+)/', '<a href="https://www.instagram.com/explore/tags/$1" target="_blank">#$1</a>', $post->caption);
            }
        }

        //turn @ into links
        foreach ($ig->data as $post) {
            if (isset($post->caption)) {
                $post->caption = preg_replace('/@([^\s]+)/', '<a href="https://www.instagram.com/$1" target="_blank">@$1</a>', $post->caption);
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
        $twitter = $this->getTwitterFeed();
        $facebook = $this->getFacebookFeed();
        $instagram = $this->getInstagramFeed();

        $feed = array_merge($twitter, $facebook, $instagram);

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
