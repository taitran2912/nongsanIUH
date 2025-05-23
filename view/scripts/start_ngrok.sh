#!/bin/bash

# Script để khởi động ngrok và lưu URL
# Sử dụng: ./start_ngrok.sh [port]

# Mặc định port là 80 nếu không được chỉ định
PORT=${1:-80}

echo "Khởi động ngrok trên port $PORT..."

# Kiểm tra xem ngrok đã được cài đặt chưa
if ! command -v ngrok &> /dev/null; then
    echo "Không tìm thấy ngrok. Vui lòng cài đặt ngrok trước."
    echo "Hướng dẫn: https://ngrok.com/download"
    exit 1
fi

# Khởi động ngrok
ngrok http $PORT > /dev/null &

# Đợi ngrok khởi động
echo "Đang đợi ngrok khởi động..."
sleep 5

# Lấy URL ngrok
NGROK_URL=$(curl -s http://127.0.0.1:4040/api/tunnels | grep -o '"public_url":"https://[^"]*' | grep -o 'https://[^"]*')

if [ -z "$NGROK_URL" ]; then
    echo "Không thể lấy URL ngrok. Vui lòng kiểm tra lại."
    exit 1
fi

# Lưu URL vào file
echo $NGROK_URL > ngrok_url.txt

echo "Ngrok đã khởi động thành công!"
echo "URL: $NGROK_URL"
echo "URL đã được lưu vào file ngrok_url.txt"

# Hiển thị thông tin cấu hình webhook
echo ""
echo "Thông tin cấu hình webhook:"
echo "Webhook URL: ${NGROK_URL}/sepay_webhook.php"
echo "Return URL: ${NGROK_URL}/?action=thank_you"
echo ""
echo "Nhấn Ctrl+C để dừng ngrok"

# Giữ script chạy để ngrok không bị tắt
wait

