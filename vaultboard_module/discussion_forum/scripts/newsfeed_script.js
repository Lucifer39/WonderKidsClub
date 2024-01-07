var newsfeedBody = document.getElementById("newsfeed-body");
let offset = 0;
let posts = [];

function get_posts() {
  // console.log(offset);
  $.ajax({
    type: "POST",
    url: "../functions/newsfeed_functions.php?function_name=get_posts",
    data: {
      offset,
    },
    success: function (res) {
      let response = JSON.parse(res);

      console.table(response);

      posts.push(...response);

      if (offset == 0) populate_posts(posts);
      else {
        append_post(response);
      }
    },
  });
}

function append_post(post) {
  // console.table(post);
  post.forEach((disc) => {
    var app_post = generate_post(disc);
    newsfeedBody.appendChild(app_post);
  });
}

function populate_posts(postList) {
  if (postList.length == 0) {
    newsfeedBody.innerText = "No posts found.";
  } else {
    newsfeedBody.innerText = "";

    postList.forEach((discussion) => {
      var post = generate_post(discussion);
      newsfeedBody.appendChild(post);
    });
  }
}

function generate_post(discussion) {
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
        vidDiv.controls = true;
        vidDiv.src = `../media_bucket/posts/vid/${file.url}`;

        postMedia.appendChild(vidDiv);
      } else if (file.fileType == "pdf") {
        const pdfDiv = document.createElement("embed");
        pdfDiv.className = "post-pdf";
        pdfDiv.src = `../media_bucket/posts/pdf/${file.url}`;

        postMedia.appendChild(pdfDiv);
      }
    });
  }

  const commentAnchor = document.createElement("button");
  commentAnchor.className = "comment-anchor-btn";

  const postCommentCount = document.createElement("div");
  postCommentCount.className = "post-comment-count";
  postCommentCount.textContent = discussion.post_comment_count + " comments";

  // commentAnchor.href = `post_page.php?pt=post_page&post_id=${discussion.post_id}`;
  // commentAnchor.appendChild(postCommentCount);

  commentAnchor.appendChild(postCommentCount);

  const commentContainer = document.createElement("div");

  commentAnchor.addEventListener("click", () => {
    $.ajax({
      type: "POST",
      url: "../functions/newsfeed_functions.php?function_name=get_comments",
      data: {
        post_id: discussion.post_id,
        limit: 3,
      },
      success: function (res) {
        let response = JSON.parse(res);
        commentAnchor.disabled = true;
        appendComments(commentContainer, response, discussion.post_id);
      },
    });
  });

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
  commentButton.id = "comment-button";
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
            window.location.href = "newsfeed.php";
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
  post.appendChild(commentAnchor);
  post.appendChild(commentType);
  post.appendChild(commentContainer);

  return post;
}

get_posts();

newsfeedBody.addEventListener("scroll", function () {
  // Check if user has reached the end of scrolling within the scroll container
  // console.log("scrolling");
  if (newsfeedBody.scrollTop + newsfeedBody.clientHeight >= newsfeedBody.scrollHeight) {
    // console.log("End of scrolling reached");
    offset++;
    get_posts();
  }
});

function appendComments(post, commentsData, post_id) {
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

    student?.id && commentVote.appendChild(likeButton);

    // Append all the elements to the comment container
    commentContent.appendChild(commentHeader);
    commentContent.appendChild(commentBody);
    commentContent.appendChild(commentVote);
    eachComment.appendChild(commentAvatar);
    eachComment.appendChild(commentContent);

    // Append the comment container to the comment section
    commentSection.appendChild(eachComment);
  });

  const loadMore = document.createElement("div");
  const loadMoreAnchor = document.createElement("a");
  loadMoreAnchor.href = student?.id ? `post_page.php?pt=post_page&post_id=${post_id}` : "#";
  loadMoreAnchor.textContent = "Load more comments...";

  if (!student?.id) {
    loadMoreAnchor.setAttribute("data-bs-toggle", "modal");

    // Set the 'data-bs-target' attribute
    loadMoreAnchor.setAttribute("data-bs-target", "#loginModal");

    // Set the 'data-card' attribute
    loadMoreAnchor.setAttribute("data-card", "discussion");
  }

  loadMore.appendChild(loadMoreAnchor);

  post.appendChild(commentSection);
  post.appendChild(loadMore);
}
