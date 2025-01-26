<!-- Modal Edit Jawaban -->
<div class="modal fade" id="editAnswerModal" tabindex="-1" aria-labelledby="editAnswerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAnswerModalLabel">Edit Jawaban</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../actions/edit-answer.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="answer_id" id="editAnswerId">
                    <div class="mb-3">
                        <label for="editAnswerContent" class="form-label">Jawaban</label>
                        <textarea name="content" id="editAnswerContent" class="form-control" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
