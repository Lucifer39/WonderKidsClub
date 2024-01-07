var newsfeedBody = document.getElementById("newsfeed-body");

function get_single_post() {
  $.ajax({
    type: "POST",
    url: "../functions/newsfeed_functions.php?function_name=get_single_post",
    data: {
      post_id,
    },
    success: function (res) {
      let response = JSON.parse(res);
      populate_post(response);
    },
  });
}

function populate_post(discussion) {
  newsfeedBody.innerText = "";

  const post = document.createElement("div");
  post.className = "post";

  const postHeader = document.createElement("div");
  postHeader.className = "post-header";

  const userImg = document.createElement("img");
  userImg.className = "post-user-img";
  userImg.src = `../../type_master/assets/avatars/${
    discussion?.student_avatar || "default-icon.svg"
  }`;
  userImg.alt = "#";

  const postUserDetails = document.createElement("span");
  postUserDetails.className = "post-user-details";

  const postUsername = document.createElement("div");
  postUsername.className = "post-username";
  postUsername.textContent = discussion.student_name;

  const postUserDetSubtitle = document.createElement("div");
  postUserDetSubtitle.className = "post-user-det-subtitle";
  postUserDetSubtitle.textContent = `${discussion.student_school} | ${discussion.student_class}`;

  postUserDetails.appendChild(postUsername);
  postUserDetails.appendChild(postUserDetSubtitle);

  postHeader.appendChild(userImg);
  postHeader.appendChild(postUserDetails);

  const postContent = document.createElement("div");
  postContent.className = "post-content-newsfeed";
  postContent.textContent = discussion.post_content;

  const postMedia = document.createElement("div");
  postMedia.className = "post-media";

  if (discussion.post_media_info) {
    const elements = discussion.post_media_info.split(",");

    const result = elements.map((element) => {
      const [url, fileType] = element.split("|");
      return { url, fileType };
    });

    result.forEach((file) => {
      if (file.fileType == "img") {
        const imgDiv = document.createElement("img");
        imgDiv.className = "post-img";
        imgDiv.src = `../media_bucket/posts/img/${file.url}`;
        imgDiv.alt = "";

        postMedia.appendChild(imgDiv);
      } else if (file.fileType == "vid") {
        const vidDiv = document.createElement("video");
        vidDiv.className = "post-vid";
        vidDiv.src = `../media_bucket/posts/vid/${file.url}`;
        vidDiv.controls = true;

        postMedia.appendChild(vidDiv);
      } else if (file.fileType == "pdf") {
        const pdfDiv = document.createElement("embed");
        pdfDiv.className = "post-pdf";
        pdfDiv.src = `../media_bucket/posts/pdf/${file.url}`;

        postMedia.appendChild(pdfDiv);
      }
    });
  }
  const postCommentCount = document.createElement("div");
  postCommentCount.className = "post-comment-count";
  postCommentCount.textContent = discussion.post_comment_count + " comments";

  const commentType = document.createElement("div");
  commentType.className = "comment-type";

  const commentImg = document.createElement("img");
  commentImg.className = "post-user-img";
  commentImg.src = `../../type_master/assets/avatars/${student?.avatar || "default-icon.svg"}`;
  commentImg.alt = "";

  const commentTextBox = document.createElement("span");
  commentTextBox.className = "comment-text-box";

  const commentInput = document.createElement("input");
  commentInput.type = "text";
  commentInput.className = "comment-input";
  commentInput.placeholder = "Add a comment";

  const commentButton = document.createElement("button");
  commentButton.className = "comment-button";
  commentButton.textContent = "Post";

  if (!student) {
    commentButton.setAttribute("data-bs-toggle", "modal");
    commentButton.setAttribute("data-bs-target", "#loginModal");
    commentButton.setAttribute("data-card", "discussion");
  }

  if (student) {
    commentButton.addEventListener("click", () => {
      $.ajax({
        type: "POST",
        url: "../functions/setter_functions.php?function_name=create_comment",
        data: {
          post_id: discussion.post_id,
          user_id: student.id,
          content: commentInput.value,
        },
        success: function (res) {
          let response = JSON.parse(res);

          if (response == "ok") {
            window.location.href = `post_page.php?pt=post_page&post_id=${discussion.post_id}`;
          }
        },
      });
    });
  }

  commentTextBox.appendChild(commentInput);
  commentTextBox.appendChild(commentButton);

  commentType.appendChild(commentImg);
  commentType.appendChild(commentTextBox);

  post.appendChild(postHeader);
  post.appendChild(postContent);
  post.appendChild(postMedia);
  post.appendChild(postCommentCount);
  post.appendChild(commentType);

  get_comments(post);

  newsfeedBody.appendChild(post);
}

function get_comments(post) {
  $.ajax({
    type: "POST",
    url: "../functions/newsfeed_functions.php?function_name=get_comments",
    data: {
      post_id,
    },
    success: function (res) {
      let response = JSON.parse(res);
      appendComments(post, response);
    },
  });
}

function appendComments(post, commentsData) {
  // Get the container element
  const commentSection = document.createElement("div");
  commentSection.className = "comment-section";

  // Loop through the comments data and create elements dynamically
  commentsData.forEach((comment) => {
    // Create the main comment container
    const eachComment = document.createElement("div");
    eachComment.classList.add("each-comment");

    // Create the comment avatar
    const commentAvatar = document.createElement("div");
    commentAvatar.classList.add("comment-avatar");
    const avatarImg = document.createElement("img");
    avatarImg.src = `../../type_master/assets/avatars/${
      comment?.student_avatar || "default-icon.svg"
    }`;
    avatarImg.alt = "";
    commentAvatar.appendChild(avatarImg);

    // Create the comment content
    const commentContent = document.createElement("div");
    commentContent.classList.add("comment-content");

    // Create the comment header
    const commentHeader = document.createElement("div");
    commentHeader.classList.add("comment-header");
    const commentUsername = document.createElement("div");
    commentUsername.classList.add("comment-username");
    commentUsername.textContent = comment.student_name;
    const commentUserDetails = document.createElement("div");
    commentUserDetails.classList.add("comment-user-det");
    commentUserDetails.textContent = comment.student_school + " | " + comment.student_class;
    commentHeader.appendChild(commentUsername);
    commentHeader.appendChild(commentUserDetails);

    // Create the comment body
    const commentBody = document.createElement("div");
    commentBody.classList.add("comment-body");
    commentBody.textContent = comment.comment_content;

    // Create the comment vote section
    const commentVote = document.createElement("div");
    commentVote.classList.add("comment-vote");
    const likeButton = document.createElement("button");
    likeButton.classList.add("like-button");
    likeButton.textContent = `Upvote ${comment.comment_vote_value || 0}`;

    likeButton.addEventListener("click", () => {
      $.ajax({
        type: "POST",
        url: "../functions/setter_functions.php?function_name=create_upvote",
        data: {
          comment_id: comment.comment_id,
          user_id: student?.id,
        },
        success: function () {
          window.location.reload();
        },
      });
    });

    $.ajax({
      type: "POST",
      url: "../functions/newsfeed_functions.php?function_name=check_upvote",
      data: {
        comment_id: comment.comment_id,
        user_id: student?.id,
      },
      success: function (res) {
        var response = JSON.parse(res);

        if (response == "voted") {
          likeButton.disabled = true;
        }
      },
    });

    student && commentVote.appendChild(likeButton);

    // Append all the elements to the comment container
    commentContent.appendChild(commentHeader);
    commentContent.appendChild(commentBody);
    commentContent.appendChild(commentVote);
    eachComment.appendChild(commentAvatar);
    eachComment.appendChild(commentContent);

    // Append the comment container to the comment section
    commentSection.appendChild(eachComment);
  });

  post.appendChild(commentSection);
}

get_single_post();
