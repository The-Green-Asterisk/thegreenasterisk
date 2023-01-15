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
            {!! $content ?? 'here is the content' !!}
        </div>
        <div class="footer">
            @if ($showCloseButton)
                <button class="close" id="closeModal" onclick="closeModal()">
                    {{ $closeButtonText ?? 'Close' }}
                </button>
            @endif
            @if ($showSubmitButton)
                <button class="submit" id="submitModal" onclick="submitModal()">
                    {{ $submitButtonText ?? 'Submit' }}
                </button>
            @endif
        </div>
    </div>
</div>
