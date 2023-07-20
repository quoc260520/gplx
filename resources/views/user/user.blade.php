<!DOCTYPE html>
<html>

<head>
    <title>Form Câu hỏi và Câu trả lời</title>
    <!-- Link đến các file Bootstrap và jQuery -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-4">
        <div class="mt-3">
            <div id="timer">Thời gian còn lại: --:--</div>
        </div>

        <h1 class="mb-4">Câu hỏi và Câu trả lời</h1>
        <div class="d-flex flex-row">
            <!-- Mini map -->
            <div class="m-2 col-4 border border-2 rounded">
                <div id="miniMap" class="d-flex flex-wrap col-12 justify-content-center h-100">
                    <!-- Mini map sẽ được thêm bằng jQuery -->
                </div>
            </div>
            <div class="col-8">
                <div id="questionContainer">
                    <!-- Câu hỏi và câu trả lời sẽ được thêm bằng jQuery -->
                </div>
                <div id="optionsContainer">
                    <!-- Nút điều hướng và nút lưu sẽ được thêm bằng jQuery -->
                </div>
                <div class="mt-3">
                    <button id="prevQuestionBtn" class="btn btn-secondary me-3" disabled>Quay lại</button>
                    <button id="nextQuestionBtn" class="btn btn-primary me-3">Tiếp theo</button>
                    <button id="saveAnswerBtn" class="btn btn-success" disabled>Lưu Đáp án</button>
                </div>
            </div>
        </div>

    </div>

    <!-- Link đến các file jQuery và Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        // Danh sách câu hỏi và câu trả lời
        let questions = [];
        for (let i = 1; i <= 25; i++) {
            let a = {
                question: `Câu hỏi ${i}: ...`,
                options: [`Câu trả lời A${i}`, `Câu trả lời B${i}`, `Câu trả lời C${i}`, `Câu trả lời D${i}`],
                answer: null,
            }
            questions.push(a)
        }
        let currentQuestionIndex = 0;
        let userAnswers = [];
        // Function để hiển thị câu hỏi và câu trả lời
        function showQuestion(index) {
            const questionContainer = $("#questionContainer");
            const optionsContainer = $("#optionsContainer");
            questionContainer.html(`<p class="fw-bold">${questions[index].question}</p>`);
            optionsContainer.html("");
            questions[index].options.forEach((option, optionIndex) => {
                const radioBtn = $(`<input type="radio" name="answer" value="${optionIndex}">`);
                const label = $(`<label class="m-3">${option}</label>`);
                const a = $("<br/>");
                optionsContainer.append(radioBtn);
                optionsContainer.append(label);
                optionsContainer.append(a);
            });
            // Kiểm tra nếu người dùng đã trả lời câu hỏi này trước đó
            const selectedAnswer = userAnswers[index];
            if (selectedAnswer !== undefined) {
                $(`input[name="answer"][value="${selectedAnswer}"]`).prop("checked", true);
            }
        }
        // Function để xử lý câu trả lời
        function handleAnswer() {
            const selectedOption = $('input[name="answer"]:checked');
            if (selectedOption.length > 0) {
                const selectedAnswer = parseInt(selectedOption.val());
                questions[currentQuestionIndex].answer = selectedAnswer;
                userAnswers[currentQuestionIndex] = selectedAnswer;
                $("#saveAnswerBtn").prop("disabled", false);
            }
        }
        // Function để hiển thị câu hỏi kế tiếp
        function nextQuestion() {
            currentQuestionIndex++;
            if (currentQuestionIndex < questions.length) {
                showQuestion(currentQuestionIndex);
                handleAnswer(); // Kiểm tra xem người dùng đã chọn câu trả lời trước đó chưa
                $("#saveAnswerBtn").prop("disabled", true);
                $("#prevQuestionBtn").prop("disabled", false);
            } else {
                alert("Bạn đã hoàn thành tất cả câu hỏi!");
                currentQuestionIndex = questions.length - 1;
                $("#nextQuestionBtn").prop("disabled", true);
                $("#saveAnswerBtn").prop("disabled", false);
            }
        }
        // Function để hiển thị câu hỏi trước đó
        function prevQuestion() {
            currentQuestionIndex--;
            if (currentQuestionIndex >= 0) {
                showQuestion(currentQuestionIndex);
                handleAnswer(); // Kiểm tra xem người dùng đã chọn câu trả lời trước đó chưa
                $("#saveAnswerBtn").prop("disabled", true);
                $("#nextQuestionBtn").prop("disabled", false);
            } else {
                alert("Đây là câu hỏi đầu tiên!");
                currentQuestionIndex = 0;
                $("#prevQuestionBtn").prop("disabled", true);
            }
        }
        // Function để lưu đáp án
        function saveAnswers() {
            console.log(questions); // Thay console.log bằng phần xử lý lưu trữ thực tế
            nextQuestion();
        }
        // Gọi function để hiển thị câu hỏi đầu tiên khi trang tải
        showQuestion(currentQuestionIndex);
        // Xử lý sự kiện khi người dùng chọn câu trả lời
        $("#optionsContainer").on("change", 'input[name="answer"]', handleAnswer);
        // Xử lý sự kiện khi người dùng nhấn nút Lưu Đáp án
        $("#saveAnswerBtn").on("click", saveAnswers);
        // Xử lý sự kiện khi người dùng nhấn nút Tiếp theo
        $("#nextQuestionBtn").on("click", nextQuestion);
        // Xử lý sự kiện khi người dùng nhấn nút Quay lại
        $("#prevQuestionBtn").on("click", prevQuestion);
        // Function để hiển thị mini map số câu hỏi
        function showMiniMap() {
            const miniMap = $("#miniMap");
            miniMap.html("");
            questions.forEach((_, index) => {
                const mapItem = $(
                    `<div class="mini-map-item mx-1 btn btn-success col-3" style="width:50px;height:50px;">${index + 1}</div>`
                );
                if (index === currentQuestionIndex) {
                    mapItem.addClass("active");
                }
                mapItem.on("click", () => {
                    showQuestion(index);
                });
                miniMap.append(mapItem);
            });
        }
        showMiniMap();
        // ... Các đoạn code trước đó ...
        // Thời gian giới hạn (đơn vị: giây)
        const timeLimit = 60; // Ví dụ 300 giây = 5 phút
        let timerInterval; // Biến để lưu đối tượng setInterval
        // Function để hiển thị thời gian
        function displayTimeRemaining(seconds) {
            const minutes = Math.floor(seconds / 60);
            const secondsRemaining = seconds % 60;
            const formattedTime = `${String(minutes).padStart(2, "0")}:${String(secondsRemaining).padStart(2, "0")}`;
            $("#timer").text("Thời gian còn lại: " + formattedTime);
        }
        // Function để bắt đầu đếm thời gian
        function startTimer() {
            let secondsRemaining = timeLimit;
            displayTimeRemaining(secondsRemaining);
            timerInterval = setInterval(() => {
                secondsRemaining--;
                displayTimeRemaining(secondsRemaining);
                if (secondsRemaining <= 0) {
                    clearInterval(timerInterval);
                    alert("Hết thời gian!");
                    // Xử lý khi thời gian hết (ví dụ: tự động lưu đáp án, ẩn form, v.v...)
                }
            }, 1000); // Cập nhật thời gian mỗi giây (1000ms)
        }
        // Function để lưu đáp án và chuyển đến câu hỏi tiếp theo
        function saveAnswersAndNext() {
            handleAnswer();
            nextQuestion();
        }
        // ... Các đoạn code khác ...
        startTimer();
    </script>
</body>

</html>
