<div class="analysis-content">
    <h1 class="title">Analysis Results</h1>

    <!-- 用户上传的图片 -->
    <div class="uploaded-image">
        @if($isForResultPage)
            <h2>Your Uploaded Image</h2>
        @endif
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

    @if($isForResultPage)
        <!-- 返回艺廊按钮 -->
        <a href="/" class="gallery-button">
            Dive back into the gallery to explore more hidden emotions.
        </a>
    @endif
</div>
<style>
    .analysis-content {
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

                h2 {
                    text-align: center;
                    color: white;
                }
            }

            .sentence p {
                font-size: 1.2rem;
                line-height: 1.6;
                font-weight: bold;
                background: linear-gradient(90deg, #58a6ff, #4caf50);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                text-shadow: 0 0 8px rgba(0, 212, 255, 0.7),
                0 0 15px rgba(0, 212, 255, 0.5);
                text-align: center;
            }

            .labels #labelsContainer {
                text-align: center;
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
                text-align: center;
            }

            .analysis-context {
                display: flex;
                justify-content: center;
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
</style>
