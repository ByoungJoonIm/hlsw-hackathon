struct meta {
	int request_number;	//요청 종류
	char id[10];		//요청자 id(학번)
	int subject_id;		//과목 고유 번호
	int assignment_id;	//과제 고유 번호(해당 과목의 과제 일련번호)
};

typedef struct meta META;
