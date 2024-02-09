let likeIcon = document.querySelectorAll(".like-box i");
let commentIcon = document.querySelectorAll(".comment-box i");

likeIcon.forEach(e => {
    e.addEventListener("mouseover", () => bgChange(e));
    e.addEventListener("mouseout", () => bgRemove(e));
});

commentIcon.forEach(e => {
    e.addEventListener("mouseover", () => bgChange(e));
    e.addEventListener("mouseout", () => bgRemove(e));
});

function bgChange(element) {
    element.classList.add("fa-solid");
}

function bgRemove(element) {
    element.classList.remove("fa-solid");
}
