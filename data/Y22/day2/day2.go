package Y22

import (
	"adventofcode/src-go/helpers"
	"strings"
)

const (
	aRock     string = "A"
	aPaper    string = "B"
	aScissors string = "C"

	bRock     string = "X"
	bPaper    string = "Y"
	bScissors string = "Z"

	resultLose string = "X"
	resultDraw string = "Y"
	resultWin  string = "Z"
)

var scoreTable = map[string]map[string]int{
	aRock: {
		bRock:     4,
		bPaper:    8,
		bScissors: 3,
	},
	aPaper: {
		bRock:     1,
		bPaper:    5,
		bScissors: 9,
	},
	aScissors: {
		bRock:     7,
		bPaper:    2,
		bScissors: 6,
	},
}

var winOrLoseTable = map[string]map[string]string{
	aRock: {
		resultWin:  bPaper,
		resultDraw: bRock,
		resultLose: bScissors,
	},
	aPaper: {
		resultWin:  bScissors,
		resultDraw: bPaper,
		resultLose: bRock,
	},
	aScissors: {
		resultWin:  bRock,
		resultDraw: bScissors,
		resultLose: bPaper,
	},
}

func Day2() helpers.DayResults {
	day2Example := helpers.ReadFileByLine("data/Y22/day2/example.txt")
	day2 := helpers.ReadFileByLine("data/Y22/day2/data.txt")

	results := helpers.DayResults{
		Day:          2,
		Year:         2022,
		Part1Example: part1(day2Example),
		Part1:        part1(day2),
		Part2Example: part2(day2Example),
		Part2:        part2(day2),
	}

	return results
}

func part1(input []string) int {
	score := 0
	for _, line := range input {
		data := strings.Split(line, " ")
		score += scoreTable[data[0]][data[1]]
	}

	return score
}

func part2(input []string) int {
	score := 0
	for _, line := range input {
		data := strings.Split(line, " ")
		scoreValue := winOrLoseTable[data[0]][data[1]]
		score += scoreTable[data[0]][scoreValue]
	}

	return score
}
