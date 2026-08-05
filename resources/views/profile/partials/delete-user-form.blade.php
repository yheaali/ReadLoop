<section>
    <h2 class="h5 text-danger">Delete account</h2>
    <p class="text-muted small">Once deleted, your data is permanently removed.</p>

    <button type="button" class="btn btn-outline-danger mt-2" data-bs-toggle="modal" data-bs-target="#confirmDeleteAccount">
        Delete account
    </button>

    <div class="modal fade" id="confirmDeleteAccount" tabindex="-1" aria-labelledby="confirmDeleteAccountLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')
                    <div class="modal-header">
                        <h2 class="modal-title h5" id="confirmDeleteAccountLabel">Confirm deletion</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="small">Enter your password to confirm.</p>
                        <label for="delete_password" class="form-label visually-hidden">Password</label>
                        <input type="password" name="password" id="delete_password" class="form-control @error('password', 'userDeletion') is-invalid @enderror" placeholder="Password" required>
                        @error('password', 'userDeletion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete permanently</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@if ($errors->userDeletion->isNotEmpty())
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                new bootstrap.Modal(document.getElementById('confirmDeleteAccount')).show();
            });
        </script>
    @endpush
@endif
