// File: assets/js/script.js

// Konfirmasi Hapus Data
function confirmDelete(itemType, itemId) {
    if (confirm(`Apakah Anda yakin ingin menghapus ${itemType} ini?`)) {
        window.location.href = `../actions/delete-${itemType}.php?id=${itemId}`;
    }
}

// Modal Edit Jawaban
const editAnswerModal = document.getElementById('editAnswerModal');
if (editAnswerModal) {
    editAnswerModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const answerId = button.getAttribute('data-answer-id');
        const answerContent = button.getAttribute('data-answer-content');
        
        document.getElementById('edit_answer_id').value = answerId;
        document.getElementById('answer_content').value = answerContent;
    });
}

// Modal Edit Komentar
const editCommentModal = document.getElementById('editCommentModal');
if (editCommentModal) {
    editCommentModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const commentId = button.getAttribute('data-comment-id');
        const commentContent = button.getAttribute('data-comment-content');
        
        document.getElementById('edit_comment_id').value = commentId;
        document.getElementById('comment_content').value = commentContent;
    });
}

// Tombol Upvote dan Downvote
function handleVote(answerId, voteType) {
    fetch(`../actions/vote-answer.php`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ answer_id: answerId, vote_type: voteType })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Vote berhasil!');
            location.reload();
        } else {
            alert(`Gagal melakukan vote: ${data.message}`);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan, silakan coba lagi.');
    });
}
