package helpers

import (
	"bufio"
	"log"
	"os"
	"strconv"
	"time"
)

func ReadFileByLine(path string) []string {
	file, err := os.Open(path)
	if err != nil {
		log.Fatal(err)
	}
	defer func(file *os.File) {
		err := file.Close()
		if err != nil {
			log.Fatal(err)
		}
	}(file)

	scanner := bufio.NewScanner(file)
	var returnData []string
	for scanner.Scan() {
		returnData = append(returnData, scanner.Text())
	}

	if err := scanner.Err(); err != nil {
		log.Fatal(err)
	}

	return returnData
}

func GetDayYear() (int, int) {
	// get current year
	year, _, day := time.Now().Date()
	// Change 2023 to 23
	year = year % 100

	if len(os.Args) == 2 {
		day, _ := strconv.Atoi(os.Args[1])
		return day, year
	}

	if len(os.Args) == 3 {
		day, _ := strconv.Atoi(os.Args[1])
		year, _ := strconv.Atoi(os.Args[2])

		return day, year
	}

	return day, year
}
