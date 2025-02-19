<div class="modal fade" id="gemniAi" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Chat với Gemini AI</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <textarea id="prompt" class="form-control mb-2" placeholder="Nhập câu hỏi của bạn..."></textarea>
                <div id="response" class="mt-3 p-3 bg-light border rounded d-none"></div>
            </div>
            <div class="modal-footer">
                <button id="applyButton" type="button" class="btn btn-secondary d-none" data-bs-dismiss="modal">Áp
                    dụng</button>
                <button type="button" id="sendButton" class="btn btn-primary">Gửi</button>
            </div>
        </div>
    </div>
</div>




@push('scripts')
    <script>
        $(document).ready(function() {
            $('#sendButton').click(function() {
                let prompt = $('#prompt').val();
                let responseDiv = $('#response');
                let sendButton = $('#sendButton');
                let applyButton = $('#applyButton');

                if (!prompt) {
                    alert("Vui lòng nhập câu hỏi!");
                    return;
                }

                sendButton.prop('disabled', true).addClass('disabled');
                responseDiv.text("Đang xử lý...").removeClass('d-none');

                $.post("{{ route('admin.gemini.ask') }}", {
                    prompt: prompt
                }, function(response) {
                    if (response && response.candidates && response.candidates.length > 0) {
                        let text = response.candidates[0].content.parts[0].text;
                        let formattedText = text.replace(/\n/g, "<br>");

                        $('#prompt').val("");

                        typeEffect(responseDiv, text, 20, function() {
                            sendButton.prop('disabled', false).removeClass('disabled');
                            applyButton.removeClass('d-none');
                        });
                    } else {
                        responseDiv.text("Không có kết quả từ API!");
                        sendButton.prop('disabled', false).removeClass('disabled');
                    }
                }).fail(function(error) {
                    console.error("Lỗi khi gọi API:", error);
                    responseDiv.text("Lỗi khi gọi API!");
                    sendButton.prop('disabled', false).removeClass('disabled');
                });
            });

            function typeEffect(element, text, speed = 30, callback) {
                element.text("");
                let index = 0;

                function typeChar() {
                    if (index < text.length) {
                        element.append(text.charAt(index));
                        index++;
                        setTimeout(typeChar, speed);
                    } else if (callback) {
                        callback();
                    }
                }
                typeChar();
            }
        });
    </script>
@endpush


@push('styles')
    <style>
        #response {
            white-space: pre-line;
        }
    </style>
@endpush
