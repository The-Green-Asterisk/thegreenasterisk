<div class="modal" id="modal">
    <div class="body">
        <div class="header">
            <h2 class="title">
                {{ $title ?? 'Why is there no title?' }}
            </h2>
            <button class="close" id="close-modal">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="content">
            {!! $content ?? 'I put this content together for you.' !!}
        </div>
        <div class="button-row">
            @if ($showCloseButton)
                <button class="btn btn-secondary" id="close-modal">
                    {{ $closeButtonText ?? 'Close' }}
                </button>
            @endif
            @if ($showSubmitButton)
                <button class="btn btn-primary" id="submit-modal">
                    {{ $submitButtonText ?? 'Submit' }}
                </button>
            @endif
        </div>
    </div>
</div>
