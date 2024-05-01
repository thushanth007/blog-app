<script>

    function submitComment(postId, commentableType) {

        var commentValue = document.getElementById('commentField_' + postId).value;

        $.ajax({
            url: '/comments',
            type: 'POST',
            data: {
                post_id: postId,
                body: commentValue,
                commentable_type: commentableType,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                // Handle success
                console.log(response.comment);
                var postComment = response.comment;
                updateCommentCount(response.comment.post_id, response.comment.comment_count);

                var commentHtml = '<div id="comment_' + postComment.id + '">' +
                    '<div class="flex items-center justify-between px-4 py-2 border-t border-gray-200">' +
                    '<div class="flex items-center space-x-2">' +
                    '<img src="https://randomuser.me/api/portraits/men/1.jpg" class="w-8 h-8 rounded-full">' +
                    '<a href="/user-post/' + postComment.user_id + '">' +
                    '<span class="text-sm">' + postComment.user_name  + '</span>' +
                    '</a>' +
                    '</div>' +
                    '<div class="flex items-center space-x-4">' +
                    '<form id="commentDeleteForm" onsubmit="event.preventDefault(); deleteComment(' + postComment.id + ')" method="POST">' +
                    '@csrf' +
                    '@method('DELETE')' +
                    '<button type="submit" id="postCommentDeleteButton" class="text-sm text-gray-500">Delete</button>' +
                    '</form>' +
                    '</div>' +
                    '</div>' +
                    '<div class="flex items-center px-12 border-gray-200 pb-2">' +
                    '<div class="flex items-center space-x-4">' +
                    postComment.body +
                    '</div>' +
                    '</div>' +
                    '</div>';

                $('#commentsSection_' + postId).append(commentHtml);

                document.getElementById('commentField_' + postId).value = '';
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

                updateCommentCount(response.post_id, response.comment);
                $('#comment_' + commentId).remove();


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

    function updateCommentCount(postId, commentCount) {
        var commentCountElement = document.getElementById('commentCount_' + postId);
        console.log('postId:', postId);
        console.log('commentCount:', commentCount);
        console.log('commentCountElement:', commentCountElement);

        if (commentCountElement && commentCountElement.dataset.postId == postId) {
            commentCountElement.innerText = commentCount + ' Comments';
        }
    }

</script>

