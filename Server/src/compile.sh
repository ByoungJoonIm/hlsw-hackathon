#!/bin/bash

len=`expr ${#1} - 2`
name=${1:0:$len}

# compile error is written to $name.rs
gcc $name.c -o $name > "$name.rs" 2>&1

filesize=$(wc -c < "$name.rs")
echo $filesize
if [ $filesize -gt 0 ]
then
	echo "compile failed!" > test.txt
else
	echo "compile successed!" > test.txt
# execution result is written to $name.rs
	./$name > $name.rs
fi
