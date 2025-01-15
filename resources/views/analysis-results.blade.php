<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Image Analysis</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style lang="scss">
        body {
            background: linear-gradient(to bottom, #0d1117, #161b22);
            color: #e6edf3;
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
            flex-direction: column;
            max-width: 800px;
            margin: 1rem auto 20px auto;
            padding: 20px;
            gap: 20px;

            h1 {
                font-size: 2.5rem;
                font-weight: bold;
                background: linear-gradient(90deg, #6a5acd, #00d4ff, #00ffb9);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                text-shadow: 0 0 10px rgba(0, 212, 255, 0.7),
                0 0 20px rgba(0, 212, 255, 0.5),
                0 0 30px rgba(106, 90, 205, 0.4);
                margin-top: 0;
                margin-bottom: 0;
                text-align: center;
            }

            .uploaded-image {
                text-align: center;
                margin-bottom: 20px;

                div img {
                    max-width: 100%;
                    border-radius: 10px;
                    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
                }
            }

            .analysis-results {
                background: rgba(255, 255, 255, 0.05);
                border-radius: 10px;
                padding: 20px;
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
                flex: 1;

                .labels,
                .sentence {
                    margin-bottom: 20px;
                }

                .sentence p {
                    margin-left: 3rem;
                    font-size: 1.2rem;
                    line-height: 1.6;
                    font-weight: bold;
                    background: linear-gradient(90deg, #58a6ff, #4caf50);
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;
                    text-shadow: 0 0 8px rgba(0, 212, 255, 0.7),
                    0 0 15px rgba(0, 212, 255, 0.5);
                }

                .labels #labelsContainer {
                    margin-left: 3rem;
                }

                .labels .label {
                    display: inline-block;
                    background: linear-gradient(90deg, #58a6ff, #4caf50);
                    color: #0d1117;
                    padding: 5px 15px;
                    border-radius: 20px;
                    font-size: 0.9rem;
                    margin: 5px;
                    box-shadow: 0 4px 10px rgba(0, 212, 255, 0.4);
                    cursor: pointer;
                    transition: transform 0.3s ease, box-shadow 0.3s ease;

                    &:hover {
                        transform: translateY(-5px) scale(1.1);
                        box-shadow: 0 8px 20px rgba(0, 255, 185, 0.6);
                    }
                }
            }

            .analysis-container {
                display: flex;
                flex-direction: column;

                h2 {
                    color: #58a6ff;
                }

                .analysis-context {
                    display: flex;
                    justify-content: start;
                    align-items: center;
                    gap: 20px;
                    height: 14rem;
                    margin-left: 3rem;

                    canvas#emotionChart {
                        width: 200px; /* 限制图表宽度 */
                        height: 200px; /* 限制图表高度 */
                    }

                    .emotion-details {
                        margin-top: 20px;
                        font-size: 1.2rem;

                        .detail-title {
                            display: block;
                            margin: 10px 0;
                            font-weight: bold;
                            color: #4caf50;

                            .detail-value {
                                color: white;
                                font-weight: lighter;
                            }
                        }
                    }
                }
            }

            .gallery-button {
                display: inline-block;
                margin: 30px auto;
                padding: 10px 30px;
                font-size: 1.2rem;
                font-weight: bold;
                text-transform: uppercase;
                color: #ffffff;
                text-decoration: none;
                background: linear-gradient(90deg, #00d4ff, #6a5acd);
                border: none;
                border-radius: 30px;
                box-shadow: 0 4px 15px rgba(0, 212, 255, 0.4);
                cursor: pointer;
                transition: all 0.3s ease, background 0.3s ease, box-shadow 0.3s ease;
                animation: float 2s infinite ease-in-out; /* 添加动画 */

                &:hover {
                    transform: scale(1.1);
                    background: linear-gradient(90deg, #6a5acd, #00d4ff);
                    box-shadow: 0 6px 20px rgba(0, 212, 255, 0.6);
                    padding: 10px 50px;
                }
            }
        }

        @keyframes float {
            0% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px); /* 向上浮动 */
            }
            100% {
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
<div class="container">
    <h1 class="title">Analysis Results</h1>

    <!-- 用户上传的图片 -->
    <div class="uploaded-image">
        <h2>Your Uploaded Image</h2>
        <div id="uploadedImage"></div>
    </div>

    <!-- 分析结果区域 -->
    <div class="analysis-results">
        <!-- 标签展示 -->
        <div class="labels">
            <h2>Identified Labels:</h2>
            <div id="labelsContainer"></div>
        </div>

        <!-- 生成的描述 -->
        <div class="sentence">
            <h2>Generated Description:</h2>
            <p id="generatedSentence"></p>
        </div>

        <div class="analysis-container">
            <h2>Emotion Analysis Visualization</h2>
            <div class="analysis-context">
                <canvas id="emotionChart" width="200" height="200"></canvas>
                <div class="emotion-details">
                    <span class="detail-title">
                        Emotion:
                        <em id="emotionType" class="detail-value">Positive</em>
                    </span>
                    <span class="detail-title">
                        Magnitude:
                        <em id="emotionMagnitude" class="detail-value">0.94</em>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- 返回艺廊按钮 -->
    <a href="/" class="gallery-button">
        Dive back into the gallery to explore more hidden emotions.
    </a>
</div>
<script>
    window.onload = async () => {
        const urlParams = new URLSearchParams(window.location.search);
        const id = urlParams.get('id');

        let apiResponse;

        await fetch(`api/analysis/${id}`).then(response => {
            if (! response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            return response.json()
        })
            .then(data => {
                console.log('API Response:', data);

                apiResponse = {
                    labels: data.data.labels,
                    sentence: data.data.sentence,
                    sentiment: data.data.sentiment,
                    imgSrc: `/storage/${data.data.image}`
                }
            })

        const imageContainer = document.getElementById('uploadedImage');
        const imgElement = document.createElement('img');
        imgElement.src = apiResponse.imgSrc;
        imgElement.alt = "uploaded Image";
        imageContainer.appendChild(imgElement);

        // 渲染标签
        const labelsContainer = document.getElementById('labelsContainer');
        apiResponse.labels.forEach(label => {
            const labelElement = document.createElement('div');
            labelElement.className = 'label';
            labelElement.textContent = label;
            labelsContainer.appendChild(labelElement);
        });

        // 渲染生成描述
        const generatedSentence = document.getElementById('generatedSentence');
        generatedSentence.textContent = apiResponse.sentence;

        // 渲染情绪分析圆饼图
        // 更新情绪类型和情绪强度的显示
        const emotionType = document.getElementById('emotionType');
        const emotionMagnitude = document.getElementById('emotionMagnitude');
        emotionType.textContent = apiResponse.sentiment.emotion;
        emotionMagnitude.textContent = apiResponse.sentiment.magnitude.toFixed(2);

        // 数据处理
        const data = {
            labels: ["Emotion Score", "Remaining"],
            datasets: [{
                label: "Emotion Score Distribution",
                data: [apiResponse.sentiment.score * 100, (1 - apiResponse.sentiment.score) * 100],
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
                        text: `${apiResponse.sentiment.emotion}`,
                        fontStyle: "Roboto",
                        color: "#4caf50", // 正面情绪颜色
                        sidePadding: 20
                    }
                }
            }
        };

        // 渲染图表
        const ctx = document.getElementById("emotionChart").getContext("2d");
        new Chart(ctx, config);
    }
</script>
</body>
</html>
