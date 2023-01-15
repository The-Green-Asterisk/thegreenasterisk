<script onload="outsideClick()"></script>
<div class="modal" id="modal" onclick="outsideClick(event)">
    <div class="body">
        <div class="header">
            <h2 class="title">
                {{ $title ?? 'Title not working' }}
            </h2>
            <button class="close" id="closeModal" onclick="closeModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="content">
            <a href="{{ url('/auth/redirect') }}">Sign In with Google</a>
            {{ $content ?? 'here is the content' }}
        </div>
        <div class="footer">
            <button class="close" id="closeModal" onclick="closeModal()">
                Close
            </button>
        </div>
    </div>
</div>
