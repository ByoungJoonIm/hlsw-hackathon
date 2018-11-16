- 작업자 : 염희수

## 스키마
### user(***id***,password,role)
사용자 정보 table
```
- id          사용자의 id (PK)
- password    사용자의 password
- role        사용자 계정에 대한 분류(학생0,교수&조교1,관리자2)
```
## student(std_id,name,cur_semester)
```
학생 정보 table

- std_id       학번 (PK)
- name         학생의 이름
- cur_semester 학생의 현재 학기

```


## professor(pro_id,name)
```
교수 정보 table

- pro_id       사번 (PK)
- name         교수의 이름

```


## subject(sub_id,year,semester,class,title)
```
과목 정보 table

- sub_id       과목코드 (PK)
- year         과목 개설 년도
- semester     과목 개설 학기
- class        분반
- title        과목명

```

## assignment(ass_number,title,text,file,deadline)
```
과제 정보 table

- ass_number       과제 번호 (PK)
- title            과제 제목
- text             과제 내용
- file             과제 
- deadline         마감일

```



database내 스키마 생성완료(11-16 21:00)
