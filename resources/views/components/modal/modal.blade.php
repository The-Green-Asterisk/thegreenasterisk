<div class="modal" id="modal" onclick="outsideClick(event)">
    <div class="body">
        <div class="header">
            <h2 class="title">
                {{ $title ?? 'Why is there no title?' }}
            </h2>
            <button class="close" id="closeModal" onclick="closeModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="content">
            {!! $content ?? 'I put this content together for you.' !!}
        </div>
        <div class="button-row">
            @if (!$showCloseButton)
                <button class="btn btn-secondary" id="closeModal" onclick="closeModal()">
                    {{ $closeButtonText ?? 'Close' }}
                </button>
            @endif
            @if (!$showSubmitButton)
                <button class="btn btn-primary" id="submitModal" onclick="submitModal()">
                    {{ $submitButtonText ?? 'Submit' }}
                </button>
            @endif
        </div>
    </div>
</div>
