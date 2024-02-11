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




// _____________________for forget user password with otp page__________________

// for otp boxes

function moveToNext(input) {
    var next = input.nextElementSibling;
    var prev = input.previousElementSibling;
    if (input.value && next) {
        next.focus();
    }
    if (!input.value && prev) {
        prev.focus();
    }
}

function handlePaste(event) {
    event.preventDefault();
    var clipboardData = event.clipboardData || window.clipboardData;
    var pastedText = clipboardData.getData('text');
    var otpBoxes = document.querySelectorAll('.otp-box');
    pastedText = pastedText.substring(0, 6); // Limit to 6 characters
    for (var i = 0; i < pastedText.length; i++) {
        otpBoxes[i].value = pastedText[i];
    }
    moveToNext(otpBoxes[pastedText.length - 1]);
}

function onlyNumbers(event) {
    var charCode = event.charCode;
    if (charCode >= 48 && charCode <= 57) {
        return true; // Allow numeric characters
    }
    return false; // Block all other characters
}