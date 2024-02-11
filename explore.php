<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Custom File Upload</title>
<style>
    #file-box {
        width: 100px;
        height: 100px;
        border: 2px dashed #ccc;
        border-radius: 5px;
        text-align: center;
        line-height: 100px;
        /* margin-bottom: 20px; */
    }
    #file-input {
        display: none;
    }
    #file-label {
        display: inline-block;
        padding: 10px 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        cursor: pointer;
    }
</style>
</head>
<body>

<div id="file-box" ondragover="allowDrop(event)"  ondrop="drop(event)">Drop here</div>

<label for="file-input" id="file-label" id="file-box" ondragover="allowDrop(event)"  ondrop="drop(event)">Select Image</label>
<input type="file" id="file-input" accept="image/*" onchange="handleFiles(event)">

<script>
function allowDrop(e) {
    e.preventDefault();
}

function drop(e) {
    e.preventDefault();
    var file = e.dataTransfer.files[0];
    handleFile(file);
}

function handleFiles(e) {
    var file = e.target.files[0];
    handleFile(file);
}

function handleFile(file) {
    if (file.type.startsWith('image/')) {
        var reader = new FileReader();
        reader.onload = function(event) {
            var image = document.createElement('img');
            image.src = event.target.result;
            image.style.maxWidth = '100%';
            image.style.maxHeight = '100%';
            document.getElementById('file-box').innerHTML = '';
            document.getElementById('file-box').appendChild(image);
        };
        reader.readAsDataURL(file);
    } else {
        alert('Please select an image file.');
    }
}
</script>

</body>
</html>
