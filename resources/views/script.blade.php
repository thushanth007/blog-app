<script>

    function submitComment(postId, commentableType) {

        var commentValue = document.getElementById('commentField_' + postId).value;

        $.ajax({
            url: '/comments',
            type: 'POST',
            data: {
                commentable_id: postId,
                body: commentValue,
                commentable_type: commentableType,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                // Handle success
                console.log(response);
            },
            error: function(xhr, status, error) {
                // Handle error
                console.error(xhr.responseText);
            }
        });
    }

    function deleteComment(commentId) {
        $.ajax({
            url: '/comments/' + commentId,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
                // Handle success
                console.log(response);
            },
            error: function(xhr, status, error) {
                // Handle error
                console.error(xhr.responseText);
            }
        });
    }

    function addLike(likeId) {
        $.ajax({
            url: '/like/' + likeId,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
                // Handle success
                console.log(response);
                updateLikeCount(response.post_id, response.likes_count);
            },
            error: function(xhr, status, error) {
                // Handle error
                console.error(xhr.responseText);
            }
        });
    }

    function updateLikeCount(postId, likesCount) {
        var likeCountElement = document.getElementById('likeCount_' + postId);
        if (likeCountElement && likeCountElement.dataset.postId == postId) {
            likeCountElement.innerText = likesCount + ' Likes';
        }
    }

</script>

