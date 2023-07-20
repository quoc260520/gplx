@extends('admin.layout')

@section('content')
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
                <form>
                    <div class="mb-3">
                        <label for="questionType" class="form-label">Question Type</label>
                        <select class="form-select" id="questionType">
                            <option value="multiple_choice">Multiple Choice</option>
                            <option value="true_false">True/False</option>
                            <!-- Add more question types as needed -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="questionText" class="form-label">Question Text</label>
                        <textarea class="form-control" id="questionText" rows="3"></textarea>
                    </div>
                    <div class="input-group mt-2">
                        <div class="input-group-text">
                            <input class="form-check-input mt-0" type="checkbox"
                                aria-label="Checkbox for following text input">
                        </div>
                        <input type="text" class="form-control" placeholder="Liệt hay không" aria-label="Liệt hay không"
                            disabled>
                    </div>
                    <div class="mb-3">
                        <label for="questionImage" class="form-label">Question Image</label>
                        <input type="file" class="form-control" id="questionImage" accept="image/*">
                    </div>
                    <div class="mb-3" id="answerOptions">
                        <label class="form-label">Answer Options:</label>
                        <!-- Dynamic input fields for answer options -->
                        <div class="input-group">
                            <div class="input-group-text">
                                <input type="checkbox" name="checkboxGroup" class="form-check-input">
                            </div>
                            <input type="text" class="form-control" placeholder="Option 1" aria-label="Option 1">
                        </div>
                        <div class="input-group mt-2">
                            <div class="input-group-text">
                                <input type="checkbox" name="checkboxGroup" class="form-check-input">
                            </div>
                            <input type="text" class="form-control" placeholder="Option 2" aria-label="Option 2">
                        </div>
                        <button class="btn btn-outline-secondary mt-2" type="button" id="add-option-btn">+</button>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Question</button>
                </form>

                <!-- Add Previous and Next buttons -->
                <div class="d-grid gap-2 mt-4">
                    <button class="btn btn-primary" type="button">Previous</button>
                    <button class="btn btn-primary" type="button">Next</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Limit the number of answer options
            var maxOptions = 4;
            var defaultOptions = 2;
            var currentOptions = defaultOptions;
            // Function to add more answer options dynamically
            function addOption() {
                var optionHtml =
                    '<div class="input-group mt-2"><div class="input-group-text"><input type="checkbox" name="checkboxGroup" class="form-check-input"></div><input type="text" class="form-control" placeholder="New Option" aria-label="New Option"><button class="btn btn-outline-secondary remove-option-btn" type="button">-</button></div>';
                $('#answerOptions').append(optionHtml);
                currentOptions++;
                checkMaxOptions();
            }
            // Function to remove answer options
            function removeOption() {
                if (currentOptions > defaultOptions) {
                    $(this).parent().remove();
                    currentOptions--;
                    checkMaxOptions();
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
            // Remove answer option when "-" button is clicked
            $(document).on('click', '.remove-option-btn', removeOption);
            $('input[name="checkboxGroup"]').on('change', function() {
                // Bỏ chọn tất cả các checkbox khác trong nhóm
                $('input[name="checkboxGroup"]').not(this).prop('checked', false);
            });
        });
    </script>
@endsection
