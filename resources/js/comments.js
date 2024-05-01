// // Function to submit a new comment via AJAX
// function submitComment(body, commentableType, commentableId) {
//     $.ajax({
//         url: '/comments',
//         type: 'POST',
//         data: {
//             body: body,
//             commentable_type: commentableType,
//             commentable_id: commentableId,
//             _token: '{{ csrf_token() }}' // Add CSRF token for Laravel protection
//         },
//         success: function(response) {
//             // Handle success
//             console.log(response);
//         },
//         error: function(xhr, status, error) {
//             // Handle error
//             console.error(xhr.responseText);
//         }
//     });
// }

// // Function to delete a comment via AJAX
// function deleteComment(commentId) {
//     $.ajax({
//         url: '/comments/' + commentId,
//         type: 'DELETE',
//         data: {
//             _token: '{{ csrf_token() }}' // Add CSRF token for Laravel protection
//         },
//         success: function(response) {
//             // Handle success
//             console.log(response);
//         },
//         error: function(xhr, status, error) {
//             // Handle error
//             console.error(xhr.responseText);
//         }
//     });
// }
