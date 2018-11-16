- 작업자 : 염희수

## 스키마
## user(id,password,role)


```
사용자 정보 table
[user]
- id          사용자의 id (PK)
- password    사용자의 password
- role        사용자 계정에 대한 분류(학생0,교수&조교1,관리자2)
```
## student(std_id,name,cur_semester)
```
학생 정보 table
[student]
- std_id       학번 (PK) - foreign key(user)
- name         학생의 이름
- cur_semester 학생의 현재 학기

```


## professor(pro_id,name)
```
교수 정보 table
[professor]
- pro_id       사번 (PK) - foreign key(user)
- name         교수의 이름

```


## subject(sub_id,year,semester,class,title)
```
과목 정보 table
[subject]
- sub_id       과목코드 (PK)
- year         과목 개설 년도
- semester     과목 개설 학기
- class        분반
- title        과목명

```

## assignment(ass_number,title,text,deadline)
```
교수/조교가 업로드한 과제 정보 table
[assignment]
- ass_number       과제 번호 (PK)
- title            과제 제목
- text             과제 내용
- deadline         마감일
- sub_id           과목코드 - foreign key(subject)

```

## std_assignment(ass_number,std_id,sub_id,text,sub_date)
```
학생이 제출한 과제 정보 table
[std_assignment]
- ass_number       과제 번호 (PK)
- std_id           학번(PK)
- text             과제 내용
- sub_date         제출일

```

+추가)
## lecture
```
교수가 강의한 수업 정보 table
[lecture]
- id             id (PK) - foreign key(user)
- sub_id         과목 id(PK) - foreign key(subject)
```

-------------------


## issue
 1. foreign key설정 error (해결 11-16 23:51)
 
 --------------------
## 구현
 - database내 스키마 생성완료(11-16 21:36)
 - 추가 table 생성(lecture)
