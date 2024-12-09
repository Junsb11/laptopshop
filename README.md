1. Cấu hình Git

git config --global user.name "Your Name"  Đặt tên người dùng.

git config --global user.email "your_email@example.com"  Đặt email người dùng.

git config --global core.editor "code --wait"  Đặt trình soạn thảo mặc định (ở đây là VS Code).

2. Khởi tạo Repository

git init  Khởi tạo một repository Git trong thư mục hiện tại.

git clone <repository_url>  Sao chép một repository từ máy chủ.

3. Theo dõi và quản lý tệp

git status  Kiểm tra trạng thái của repository.

git add <file>  Thêm tệp cụ thể vào khu vực staging.

git add .  Thêm tất cả tệp đã thay đổi vào khu vực staging.

git rm --cached <file>  Xóa tệp ra khỏi staging mà không xóa tệp gốc.

4. Commit

git commit -m "message"  Lưu các thay đổi trong khu vực staging với thông điệp commit.

git commit --amend -m "new message"  Sửa đổi commit cuối cùng.

5. Làm việc với nhánh (Branch)

git branch  Hiển thị danh sách các nhánh.

git branch <branch_name>
Tạo một nhánh mới.
git checkout <branch_name>
Chuyển sang nhánh khác.
git checkout -b <branch_name>
Tạo và chuyển sang nhánh mới.
git merge <branch_name>
Gộp nhánh được chỉ định vào nhánh hiện tại.
git branch -d <branch_name>
Xóa một nhánh (đã được merge)

6. Làm việc với Remote

git remote add origin <repository_url>  Liên kết repository cục bộ với remote repository.

git push -u origin <branch_name>  Đẩy nhánh lên remote lần đầu tiên.

git push  Đẩy các thay đổi lên remote.

git pull  Lấy các thay đổi mới nhất từ remote.

git fetch  Lấy dữ liệu từ remote nhưng không tự động merge.
7. Quản lý lịch sử
git log  Hiển thị lịch sử commit.
git log --oneline
Hiển thị lịch sử commit ngắn gọn.
git diff
So sánh sự khác biệt giữa các thay đổi chưa staged.

git reset <commit_hash>  Đặt lại repository về trạng thái của commit chỉ định.

git revert <commit_hash>  Tạo một commit mới để đảo ngược commit chỉ định.

8. Khác

git stash  Lưu tạm thời các thay đổi chưa commit.

git stash pop  Khôi phục các thay đổi từ stash.

git tag <tag_name>  Tạo một thẻ (tag) cho một commit cụ thể.
