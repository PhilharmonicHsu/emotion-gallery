<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Your Image</title>
    <style lang="scss">
        body {
            background: linear-gradient(to bottom, #0d1117, #161b22);
            color: #e6edf3;
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        h1 {
            font-size: 2.5rem;
            font-weight: bold;
            background: linear-gradient(90deg, #6a5acd, #00d4ff, #00ffb9);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 0 10px rgba(0, 212, 255, 0.7),
            0 0 20px rgba(0, 212, 255, 0.5),
            0 0 30px rgba(106, 90, 205, 0.4);
        }

        .upload-box {
            margin-top: 20px;
            padding: 20px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            max-width: 400px;
        }

        input[type="file"] {
            width: 90%;
            padding: 10px;
            margin-top: 10px;
            border: 2px dashed #6a5acd;
            border-radius: 10px;
            background: rgba(0, 0, 0, 0.1);
            color: #e6edf3;
            font-size: 1rem;
            outline: none;
            transition: border 0.3s ease, background 0.3s ease;
            cursor: pointer;
        }

        input[type="file"]:hover {
            border-color: #00d4ff;
            background: rgba(0, 0, 0, 0.2);
        }

        button {
            margin-top: 20px;
            padding: 10px 30px;
            font-size: 1.2rem;
            font-weight: bold;
            text-transform: uppercase;
            color: #ffffff;
            background: linear-gradient(90deg, #00d4ff, #6a5acd);
            border: none;
            border-radius: 30px;
            box-shadow: 0 4px 15px rgba(0, 212, 255, 0.4);
            cursor: pointer;
            transition: transform 0.3s ease, background 0.3s ease, box-shadow 0.3s ease;
        }

        button:hover {
            transform: scale(1.1);
            background: linear-gradient(90deg, #6a5acd, #00d4ff);
            box-shadow: 0 6px 20px rgba(0, 212, 255, 0.6);
        }

        .preview {
            margin-top: 20px;
        }

        .preview img {
            max-width: 100%;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        #loadingSpinner {
            display: none; /* 預設隱藏 */
            margin-left: 10px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #3498db;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        .loading-text {
            display: none; /* 預設隱藏 */
            margin-left: 10px;
        }

        .loading-active #loadingSpinner,
        .loading-active .loading-text {
            display: inline-block; /* 顯示動畫和文字 */
        }

        .loading-active #submitButton {
            display: none; /* 隱藏按鈕 */
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Upload Your Image</h1>
    <div class="upload-box">
        @csrf
        <form id="uploadForm" enctype="multipart/form-data" method="POST" action="{{ route('upload') }}">
            <input type="file" name="image" id="imageInput" accept="image/*" required>
            <!-- 图片预览区域 -->
            <div class="preview" id="previewContainer" style="display: none;">
                <h2>Preview:</h2>
                <img id="previewImage" src="#" alt="Selected Image">
            </div>
            <button type="submit" id="submitButton">Submit</button>
        </form>
    </div>
</div>

<script>
    const MAX_FILE_SIZE = 2 * 1024 * 1024; // 限制大小為 2MB

    const imageInput = document.getElementById('imageInput');
    const previewContainer = document.getElementById('previewContainer');
    const previewImage = document.getElementById('previewImage');

    imageInput.addEventListener('change', (event) => {
        const file = event.target.files[0];
        if (file) {
            if (file.size > MAX_FILE_SIZE) {
                alert("The image is too big!")
                imageInput.value = '';

                return;
            }

            const reader = new FileReader();
            reader.onload = (e) => {
                previewImage.src = e.target.result; // 设置预览图片的源
                previewContainer.style.display = 'block'; // 显示预览区域
            };

            reader.readAsDataURL(file); // 读取文件为 DataURL
        } else {
            previewContainer.style.display = 'none'; // 如果未选择文件，则隐藏预览
        }
    });

    document.getElementById('uploadForm').addEventListener('submit', function (e) {
        const submitButton = document.getElementById('submitButton');
        const loadingWrap = document.createElement('div');
        const loadingSpinner = document.createElement('div');
        loadingSpinner.id = 'loadingSpinner';

        const loadingText = document.createElement('span');
        loadingText.className = 'loading-text';
        loadingText.innerText = 'Analyzing...';

        loadingWrap.appendChild(loadingSpinner)
        loadingWrap.appendChild(loadingText)
        loadingWrap.style.display = 'flex'
        loadingWrap.style.justifyContent = 'center';
        loadingWrap.style.marginTop = '1.5rem'

        submitButton.parentNode.appendChild(loadingWrap);

        this.classList.add('loading-active');
    });
</script>
</body>
</html>
