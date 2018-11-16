- 작업자 : 염희수


| user             |     //사용자 정보 table
| -----------------|
| id - PK          |     //사용자의 id
| password         |     //사용자의 비밀번호
| role             |     //사용자 계정에 대한 분류(학생0,교수&조교1,관리자2)



| student           |     학생 정보 table
| ------------------|
| student_number -PK|     학번     
| name              |     학생의 이름
| cur_semester      |     학생의 현재 학기 (예,3학년1학기라면 5)


| professor      |        교수 정보 table
| -------------- |
| pro_number - PK|        사번       
| name           |        교수의 이름



| subject        |        과목 정보 table
| -------------- |
| sub_id  - PK   |        과목코드
| year           |        과목 개설 년도
| semester       |        과목 개설 학기
| class          |        분반
| title          |        과목명



| assignmen         |     과제 정보 table
| ----------------- |
| ass_number -PK    |     과제 번호
| title             |     과제 제목
| text              |     과제 내용
| deadline          |     마감일


