@extends('admin.layout')

@section('content')

    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="#">Exam</a>
                <!-- Navigation links -->
            </div>
        </nav>

        <div class="container my-5">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <!-- Form to add a new question -->
                    <form method="POST" action="{{ route('answer.post.create') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="questionType" class="form-label">Loại câu hỏi <span
                                    class="text-red">(*)</span></label>
                            <select class="form-select" id="questionType" name="kind">
                                @foreach ($kinds as $kind)
                                    <option value="{{ $kind->id }}"
                                        {{ old('kind') ? (old('kind') == $kind->id ? 'selected' : '') : '' }}>
                                        {{ $kind->name }}</option>
                                @endforeach
                                <!-- Add more question types as needed -->
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="questionText" class="form-label">Câu hỏi <span class="text-red">(*)</span></label>
                            <textarea class="form-control" id="questionText" rows="3" name="question">{{ old('question') ?? '' }}</textarea>
                        </div>
                        <div class="input-group mt-2">
                            <div class="input-group-text" style="padding-left: 38px;">
                                <input class="form-check-input mt-0" type="checkbox"
                                    aria-label="Checkbox for following text input">
                            </div>
                            <input type="text" class="form-control" placeholder="Câu liệt" aria-label="Câu liệt"
                                disabled>
                        </div>
                        <div class="mb-3 mt-2">
                            <label for="questionImage" class="form-label">Hình ảnh</label>
                            <input type="file" class="form-control" id="questionImage" accept="image/*">
                        </div>
                        <div class="mb-3" id="answerOptions">
                            <label class="form-label">Câu trả lời <span class="text-red">(*)</span></label>
                            <div class="input-group">
                                <div class="input-group-text" style="padding-left: 38px;">
                                    <input type="checkbox" name="is_correct[]" value="1" class="form-check-input">
                                </div>
                                <input type="text" class="form-control" placeholder="Câu trả lời 1"
                                    aria-label="Câu trả lời 1" name="answers[]" value="{{ old('answers.0') }}">
                            </div>
                            <div class="input-group mt-2">
                                <div class="input-group-text" style="padding-left: 38px;">
                                    <input type="checkbox" name="is_correct[]" value="2" class="form-check-input">
                                </div>
                                <input type="text" class="form-control" placeholder="Câu trả lời 2"
                                    aria-label="Câu trả lời 2" name="answers[]" value="{{ old('answers.1') }}">
                            </div>
                            @if (old('currentOptions'))
                                @for ($i = 1; $i <= old('currentOptions') - 2; $i++)
                                    <div class="input-group mt-2">
                                        <div class="input-group-text" style="padding-left: 38px;">
                                            <input type="checkbox" name="is_correct[]" value="{{ $i + 2 }}"
                                                class="form-check-input">
                                        </div>
                                        <input type="text" class="form-control"
                                            placeholder="Câu trả lời {{ $i + 2 }}" aria-label="Câu trả lời 2"
                                            name="answers[]" value="{{ old('answers.') }}">
                                        <button class="btn btn-outline-secondary remove-option-btn"
                                            type="button">-</button>

                                    </div>
                                @endfor
                            @endif
                            <input type="hidden" name="currentOptions" id="currentOptions" value="2">
                            <button class="btn btn-outline-secondary mt-2" type="button" id="add-option-btn">+</button>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Question</button>
                    </form>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                // Limit the number of answer options
                var maxOptions = 4;
                var defaultOptions = 2;
                var currentOptions = defaultOptions;
                checkMaxOptions()
                // Function to add more answer options dynamically
                function addOption() {
                    var optionHtml =
                        `<div class="input-group mt-2">
                            <div class="input-group-text" style="padding-left: 38px;">
                                <input type="checkbox" name="is_correct[]" value="${currentOptions + 1}"" class="form-check-input">
                            </div>
                                <input type="text" class="form-control" placeholder="Câu trả lời ${currentOptions + 1}" aria-label="Câu trả lời" name="answers[]">
                                <button class="btn btn-outline-secondary remove-option-btn" type="button">-</button>
                            </div>`;
                    $('#answerOptions').append(optionHtml);
                    currentOptions++;
                    $('#currentOptions').val(currentOptions);
                    checkMaxOptions();
                    changeCheckbox();
                }
                // Function to remove answer options
                function removeOption() {
                    if (currentOptions > defaultOptions) {
                        $(this).parent().remove();
                        currentOptions--;
                        checkMaxOptions();
                        $('#currentOptions').val(currentOptions);

                    }
                }
                // Check if the max number of options has been reached
                function checkMaxOptions() {
                    if (currentOptions >= maxOptions) {
                        $('#add-option-btn').prop('disabled', true);
                    } else {
                        $('#add-option-btn').prop('disabled', false);
                    }
                }
                // Add more answer options when "+" button is clicked
                $('#add-option-btn').click(addOption);
                $(document).on('click', '.remove-option-btn', removeOption);

                function changeCheckbox() {
                    $('input[name="is_correct[]"]').on('change', function() {
                        console.log(1234);
                        $('input[name="is_correct[]"]').not(this).prop('checked', false);
                    });
                }
                changeCheckbox();


            });
        </script>
    </body>
@endsection
