<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artistic Image Layout</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style lang="scss">
        body {
            background: linear-gradient(to bottom, #0d1117, #161b22);
            color: #e6edf3;
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        .gallery {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px; /* 图片间距 */
            max-width: 90%; /* 限制画廊宽度 */
            margin: 10px auto 50px auto;
            padding: 20px;
        }

        .gallery .img-box {
            flex-grow: 1;
            flex-basis: calc(30% - 15px); /* 每张图片的初始大小 */
            height: 200px; /* 图片保持宽高比 */
            width: auto;
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.5);
            transition: transform 0.4s ease, box-shadow 0.4s ease, filter 0.4s ease;
            background-color: #00d4ff;
            overflow: hidden;
            display: inline-block; /* 确保 div 是 inline-block */

            img {
                object-fit: cover;
                height: 200px;
                width: 100%;
            }
        }

        /* 鼠标悬停效果 */
        .gallery .img-box:hover {
            transform: scale(1.1) rotate(-2deg); /* 放大并旋转 */
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.7);
            filter: brightness(1.2) contrast(1.1);
        }

        /* 控制特定图片大小 */
        .gallery .large {
            flex-basis: calc(40% - 15px);
        }

        .gallery .tall {
            flex-basis: calc(20% - 15px);
        }

        .gallery .img-box:hover::after {
            opacity: 0;
        }

        .try-it {
            margin-bottom: 10rem;
            height: 5rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;

            .cta {
                font-size: 1.8rem;
                font-weight: bold;
                line-height: 1.5;
                text-align: center;
                background: linear-gradient(90deg, #6a5acd, #00d4ff, #00ffb9);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                position: relative;
                text-shadow: 0 0 10px rgba(0, 212, 255, 0.7),
                0 0 20px rgba(0, 212, 255, 0.5),
                0 0 30px rgba(106, 90, 205, 0.4);
                margin: 0 auto;
                padding: 10px 20px;
                width: 90%;

                &:hover {
                    transform: scale(1.05);
                    text-shadow: 0 0 15px rgba(0, 255, 185, 0.8),
                    0 0 30px rgba(0, 255, 185, 0.6),
                    0 0 45px rgba(0, 212, 255, 0.5);
                    transition: transform 0.3s ease, text-shadow 0.3s ease;
                }
            }

            .cta-action {
                margin-top: 20px;

                .upload-btn {
                    display: inline-block;
                    margin-top: 20px;
                    font-size: 1.2rem;
                    font-weight: bold;
                    text-transform: uppercase;
                    color: #ffffff;
                    text-decoration: none;
                    padding: 10px 30px;
                    background: linear-gradient(90deg, #00d4ff, #6a5acd);
                    border: none;
                    border-radius: 30px;
                    box-shadow: 0 4px 15px rgba(0, 212, 255, 0.4);
                    transition: all 0.3s ease, background 0.3s ease, box-shadow 0.3s ease;
                }

                .upload-btn:hover {
                    padding: 10px 50px;
                    transform: scale(1.1);
                    background: linear-gradient(90deg, #6a5acd, #00d4ff);
                    box-shadow: 0 6px 20px rgba(0, 212, 255, 0.6);
                }
            }
        }

        .title {
            font-size: 3rem;
            font-weight: bold;
            text-transform: uppercase;
            background: linear-gradient(90deg, #6a5acd, #00d4ff, #00ffb9);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            position: relative;
            text-shadow: 0 0 10px rgba(0, 212, 255, 0.7),
            0 0 20px rgba(0, 212, 255, 0.5),
            0 0 30px rgba(106, 90, 205, 0.4);
            animation: glow 3s infinite alternate;
            margin-bottom: 20px;
        }

        @keyframes moveGlow {
            0% {
                transform: translate(-50%, -50%) rotate(0deg);
            }
            100% {
                transform: translate(-50%, -50%) rotate(360deg);
            }
        }

        .title:hover {
            transform: scale(1.1);
            text-shadow: 0 0 15px rgba(0, 255, 185, 0.8),
            0 0 30px rgba(0, 255, 185, 0.6),
            0 0 45px rgba(0, 212, 255, 0.5);
            transition: transform 0.3s ease, text-shadow 0.3s ease;
        }

        @keyframes glow {
            from {
                text-shadow: 0 0 10px rgba(0, 212, 255, 0.7),
                0 0 20px rgba(0, 212, 255, 0.5),
                0 0 30px rgba(106, 90, 205, 0.4);
            }
            to {
                text-shadow: 0 0 15px rgba(0, 255, 185, 0.8),
                0 0 30px rgba(0, 255, 185, 0.6),
                0 0 45px rgba(0, 212, 255, 0.5);
            }
        }

        dialog {
            width: 60%;
            max-width: 500px;
            border: none;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            background: linear-gradient(to bottom, #0d1117, #161b22);
            position: relative;

            &::backdrop {
                background-color: rgba(0, 0, 0, 0.5);
            }

            .close-dialog {
                position: absolute;
                top: 10px;
                right: 10px;
                background: none;
                border: none;
                font-size: 1.5rem;
                color: #888;
                cursor: pointer;

                &:hover {
                    color: #333;
                }
            }


        }
    </style>
</head>
<body>
<div class="container">
    <h1 class="title">Emotion Gallery</h1>
    <section class="gallery" id="gallery"></section>
</div>
<!-- Dialog -->
<dialog id="dialog">
    <button class="close-dialog" id="closeDialog">×</button>
    @include('components.analysis-result', ['isForResultPage' => false])
</dialog>

<section class="try-it">
    <h2 class="cta">
        Unveil the emotions within—now it’s your turn! <br>
        Upload your own image and let us uncover the hidden stories and feelings together.
    </h2>
    <div class="cta-action">
        <a href="/upload" class="upload-btn">Upload Now</a>
    </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js"></script>
<script>
    let apiResponse;
    let chartInstance;

    window.onload = async () => {
        await fetch('api/recent-analysis').then(response => {
            if (! response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            return response.json()
        })
            .then(data => {
                apiResponse = data.map(analysisResult => {
                    return {
                        id: analysisResult.id,
                        labels: analysisResult.data.labels,
                        sentence: analysisResult.data.sentence,
                        sentiment: analysisResult.data.sentiment,
                        imgSrc: analysisResult.data.image
                    }
                })

            })

        const gallery = document.getElementById('gallery')

        apiResponse.map((analysisResult) => {
            const div = document.createElement('div');
            div.classList.add('img-box')
            const random = Math.round(Math.random() * 2)

            switch (random) {
                case 0: div.classList.add('large'); break;
                case 1: div.classList.add('tall'); break;
            }

            const img = document.createElement('img');
            img.src = analysisResult.imgSrc;
            img.alt = analysisResult.sentence;
            img.dataset.id = analysisResult.id;
            img.style.cursor = 'pointer';

            div.appendChild(img);

            gallery.appendChild(div);
        })

        const imgBoxes = document.querySelectorAll('.gallery .img-box');
        const dialog = document.getElementById("dialog");
        const closeDialog = document.getElementById("closeDialog");

        imgBoxes.forEach(imgBox => {
            imgBox.addEventListener('click', () => {
                const childrenImg = imgBox.querySelector('img')
                const imgInfo = apiResponse.find(data => data.id === Number(childrenImg.dataset.id))

                const imageContainer = document.getElementById('uploadedImage');
                imageContainer.innerHTML = '';
                const imgElement = document.createElement('img');
                imgElement.src = imgInfo.imgSrc;
                imgElement.alt = imgInfo.sentence;
                imageContainer.appendChild(imgElement);

                // 渲染标签
                const labelsContainer = document.getElementById('labelsContainer');
                labelsContainer.innerHTML = '';

                imgInfo.labels.forEach(label => {
                    const labelElement = document.createElement('div');
                    labelElement.className = 'label';
                    labelElement.textContent = label;
                    labelsContainer.appendChild(labelElement);
                });

                // 渲染生成描述
                const generatedSentence = document.getElementById('generatedSentence');
                generatedSentence.textContent = imgInfo.sentence;

                // 渲染情绪分析圆饼图
                // 更新情绪类型和情绪强度的显示
                const emotionType = document.getElementById('emotionType');
                const emotionMagnitude = document.getElementById('emotionMagnitude');
                emotionType.textContent = imgInfo.sentiment.emotion;
                emotionMagnitude.textContent = imgInfo.sentiment.magnitude.toFixed(2);

                // 数据处理
                const data = {
                    labels: ["Emotion Score", "Remaining"],
                    datasets: [{
                        label: "Emotion Score Distribution",
                        data: [imgInfo.sentiment.score * 100, (1 - imgInfo.sentiment.score) * 100],
                        backgroundColor: ["#4caf50", "#e0e0e0"], // 正面为绿色，剩余为灰色
                        hoverBackgroundColor: ["#66bb6a", "#bdbdbd"]
                    }]
                };

                // 配置
                const config = {
                    type: "doughnut",
                    data: data,
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: "top",
                                labels: {
                                    color: "#e6edf3"
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function (tooltipItem) {
                                        return `${tooltipItem.label}: ${tooltipItem.raw.toFixed(1)}%`;
                                    }
                                }
                            }
                        },
                        cutout: "70%", // 中心空心半径
                        elements: {
                            center: {
                                text: `${imgInfo.sentiment.emotion}`,
                                fontStyle: "Roboto",
                                color: "#4caf50", // 正面情绪颜色
                                sidePadding: 20
                            }
                        }
                    }
                };

                // 渲染图表
                const ctx = document.getElementById("emotionChart").getContext("2d");

                if (chartInstance) {
                    chartInstance.destroy();
                }

                chartInstance = new Chart(ctx, config);

                dialog.showModal(); // Open dialog
            });
        });

        // Close dialog when the close button is clicked
        closeDialog.addEventListener("click", () => {
            dialog.close(); // Close dialog
        });

        // Optionally prevent clicking outside dialog from closing it
        dialog.addEventListener("cancel", (event) => {
            event.preventDefault(); // Prevent default behavior (close dialog)
        });
    };
</script>
</body>
</html>
