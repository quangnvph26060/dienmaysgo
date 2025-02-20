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
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
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
                    console.log(response);

                    if (response && response.html) {
                        let htmlContent = response.html; // Dữ liệu đã là HTML

                        $('#prompt').val("");

                        typeEffect(responseDiv, htmlContent, 20, function() {
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

            function typeEffect(element, htmlContent, speed = 30, callback) {
                element.html(""); // Xóa nội dung cũ

                let words = htmlContent.split(" "); // Chia thành từng từ để đảm bảo HTML không bị cắt
                let index = 0;
                let output = "";

                function typeWord() {
                    if (index < words.length) {
                        output += words[index] + " "; // Thêm từng từ
                        element.html(output + "<span>|</span>"); // Hiển thị hiệu ứng con trỏ
                        index++;
                        setTimeout(typeWord, speed);
                    } else {
                        element.html(output); // Xóa con trỏ sau khi hoàn thành
                        if (callback) callback();
                    }
                }

                typeWord();
            }
        });
    </script>
@endpush


@push('styles')
    {{-- <style>
        #response {
            white-space: pre-line;
        }
    </style> --}}
@endpush
