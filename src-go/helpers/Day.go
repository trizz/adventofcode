package helpers

import (
	"strconv"
	"strings"

	"github.com/fatih/color"
)

type DayResults struct {
	Day          int `json:"day"`
	Year         int `json:"year"`
	Part1Example int `json:"part1-example"`
	Part1        int `json:"part1"`
	Part2Example int `json:"part2-example"`
	Part2        int `json:"part2"`
}

func PrintDayResults(results DayResults) {
	yellow := color.New(color.FgYellow).SprintFunc()
	gray := color.New(color.FgHiBlack).SprintFunc()

	color.HiBlue("Day %d%s", results.Day, gray("/"+strconv.Itoa(results.Year)))
	color.Green("  Part 1 (example): %s", yellow(results.Part1Example))
	color.HiGreen("  Part 1          : %s", yellow(results.Part1))
	color.Blue("  " + strings.Repeat("-", 23))
	color.Green("  Part 2 (example): %s", yellow(results.Part2Example))
	color.HiGreen("  Part 2          : %s", yellow(results.Part2))
}
