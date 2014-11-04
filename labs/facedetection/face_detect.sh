#!/bin/bash

find ./input -name "*.jpg" | while read file; do
	br -algorithm  FaceRecognition -enrollAll -enroll *.jpg  metadata.csv
done
