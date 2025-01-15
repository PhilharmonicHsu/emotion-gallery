<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Image Analysis</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2&display=swap" rel="stylesheet">
    <style lang="scss">
        body {
            background: linear-gradient(to bottom, #0d1117, #161b22);
            color: #e6edf3;
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
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
@include('components.analysis-result', ['isForResultPage' => true])
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
                apiResponse = {
                    labels: data.data.labels,
                    sentence: data.data.sentence,
                    sentiment: data.data.sentiment,
                    imgSrc: data.data.image
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
