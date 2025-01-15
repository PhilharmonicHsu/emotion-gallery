<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artistic Image Layout</title>
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

        .gallery img {
            flex-grow: 1;
            flex-basis: calc(10% - 15px); /* 每张图片的初始大小 */
            height: 200px; /* 图片保持宽高比 */
            width: auto;
            object-fit: cover;
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.5);
            transition: transform 0.4s ease, box-shadow 0.4s ease, filter 0.4s ease;
        }

        /* 鼠标悬停效果 */
        .gallery img:hover {
            transform: scale(1.1) rotate(-2deg); /* 放大并旋转 */
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.7);
            filter: brightness(1.2) contrast(1.1);
        }

        /* 控制特定图片大小 */
        .gallery .large {
            flex-basis: calc(15% - 15px);
        }
        .gallery .tall {
            flex-basis: calc(5% - 15px);
        }

        /* 动态渐变背景 */
        .gallery img::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.5));
            z-index: 1;
            transition: opacity 0.4s ease;
        }

        .gallery img:hover::after {
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

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 999;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        .overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* Modal 样式 */
        .modal {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.5);
            width: 80%;
            max-width: 600px;
            padding: 20px;
            border-radius: 10px;
            z-index: 1001;
            visibility: hidden;
            opacity: 0;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        .modal.active {
            visibility: visible;
            opacity: 1;
        }

        .modal-header {
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
            color: #58a6ff;
        }

        .modal-body {
            text-align: center;
            color: #e6edf3;
        }

        .modal img {
            max-width: 100%;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .close-modal {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 1.2rem;
            color: #fff;
            cursor: pointer;
            background: rgba(255, 255, 255, 0.2);
            padding: 5px 10px;
            border-radius: 50%;
            transition: background 0.3s ease;
        }

        .close-modal:hover {
            background: rgba(255, 255, 255, 0.5);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="title">Emotion Gallery</h1>
        <section class="gallery" id="gallery"></section>
    </div>

    <section class="try-it">
        <h2 class="cta">
            Unveil the emotions within—now it’s your turn! <br>
            Upload your own image and let us uncover the hidden stories and feelings together.
        </h2>
        <div class="cta-action">
            <a href="/upload" class="upload-btn">Upload Now</a>
        </div>
    </section>
    <!-- 背景遮罩 -->
    <div class="overlay" id="overlay"></div>

    <!-- Modal -->
    <div class="modal" id="modal">
        <span class="close-modal" id="closeModal">×</span>
        <div class="modal-header">Analysis Results</div>
        <div class="modal-body" id="modalContent"></div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js"></script>
    <script>
        let apiResponse;

        window.onload = async () => {
            await fetch('api/recent-analysis').then(response => {
                if (! response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                return response.json()
            })
                .then(data => {
                    console.log(data)

                    apiResponse = data.map(analysisResult => {
                        return {
                            id: analysisResult.id,
                            labels: analysisResult.data.labels,
                            sentence: analysisResult.data.sentence,
                            sentiment: analysisResult.data.sentiment,
                            imgSrc: `/storage/${analysisResult.data.image}`
                        }
                    })

                })

            const gallery = document.getElementById('gallery')

            apiResponse.map((analysisResult) => {
                const div = document.createElement('div');
                const img = document.createElement('img');

                const random = Math.round(Math.random() * 2)

                switch (random) {
                    case 0: img.classList.add('large') ; break;
                    case 1: img.classList.add('tall'); break;
                }

                img.src = analysisResult.imgSrc;
                img.alt = analysisResult.sentence;
                img.dataset.id = analysisResult.id;
                img.style.cursor = 'pointer';


                gallery.appendChild(img);

            })

            const images = document.querySelectorAll('.gallery img');
            const overlay = document.getElementById('overlay');

            images.forEach(image => {
                image.addEventListener('click', () => {
                    const targetWidth = image.width;
                    const targetHeight = image.height;

                    // 获取图片的初始位置和大小
                    let rect = image.getBoundingClientRect();

                    const clone = image.cloneNode(true); // 克隆图片
                    document.body.appendChild(clone);

                    // 设置克隆图片的初始样式
                    const top = rect.top + 'px';
                    const left = rect.left + 'px'
                    const width = `${targetWidth}px`;
                    const height = `${targetHeight}px`;

                    gsap.set(clone, {
                        position: 'fixed',
                        top: top,
                        left: left,
                        width: width,
                        height: height,
                        borderRadius: '20px', // 初始化圆角
                        margin: 0,
                        zIndex: 1000,
                        transition: 'none',
                        overflow: 'hidden'
                    });

                    // 显示遮罩层
                    overlay.classList.add('active');

                    // 使用 GSAP 动画移动和放大图片
                    gsap.to(clone, {
                        top: '50%',
                        left: '50%',
                        x: '-50%',
                        y: '-50%',
                        width: '30rem',
                        height: 'auto',
                        objectFit: 'cover',
                        borderRadius: '20px',
                        duration: 0.8,
                        ease: 'power3.out',
                        onStart: () => {
                            image.style.opacity = '0';
                        },
                        onComplete: () => {
                            // 显示卡片内容（你可以在这里动态插入内容）
                            console.log('动画完成');
                            const diaaa = document.getElementById('diaaa');
                            diaaa.show()
                        }
                    });

                    // 点击遮罩关闭动画
                    overlay.addEventListener('click', () => {
                        // 关闭遮罩
                        overlay.classList.remove('active');

                        // 恢复图片到初始位置
                        gsap.to(clone, {
                            top: (rect.top + (image.height / 2) + 22.5)  + 'px',
                            left: (rect.left + (image.width / 2) + 21.5) + 'px',
                            width: image.width + 'px',
                            height: image.height + 'px',
                            borderRadius: '20px',
                            duration: 0.8,
                            objectFit: 'cover',
                            ease: 'power3.inOut',
                            onComplete: () => {
                                clone.remove(); // 移除克隆图片
                                image.style.opacity = '1';
                            }
                        });
                    });
                });
            });
        };
    </script>
</body>
</html>
