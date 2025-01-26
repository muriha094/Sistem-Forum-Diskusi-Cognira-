<!-- Modal Edit Pertanyaan -->
<div class="modal fade" id="editQuestionModal" tabindex="-1" aria-labelledby="editQuestionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editQuestionModalLabel">Edit Pertanyaan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../actions/edit-question.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="question_id" id="editQuestionId">
                    <div class="mb-3">
                        <label for="editQuestionTitle" class="form-label">Judul Pertanyaan</label>
                        <input type="text" name="title" id="editQuestionTitle" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="editQuestionContent" class="form-label">Isi Pertanyaan</label>
                        <textarea name="content" id="editQuestionContent" class="form-control" rows="3" required></textarea>
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
