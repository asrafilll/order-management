<div
    class="modal fade"
    id="signout"
>
    <div class="modal-dialog">
        <form
            action="{{ route('auth.login.destroy') }}"
            method="POST"
        >
            @csrf
            @method('DELETE')
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('Sign Out') }}</h4>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close"
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>{{ __('Are you sure want to signout?') }}</p>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-default"
                        data-dismiss="modal"
                    >{{ __('No') }}</button>
                    <button
                        type="submit"
                        class="btn btn-primary"
                    >{{ __('Yes') }}</button>
                </div>
            </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
