# 8queens

Find a valid solution for the 8 queen problem with some branch and bound techniques and OOP

Compatible with php8, runnit with:

```
php play.php
```

You can change the histogram of results tracked and the bounds of the scanning for loser moves with those two variables in the EightQueens findSolution method (change it in play.php):

```
findSolution($numSolutionsToTrack=5, $limitSearch=5)
```

Where:
**numSolutionsToTrack** is the array of the number of killer move array shown in each step
For example: SolutionArray: 1,10,37,1
Indicates that the algorithm has scanned 1 solution with 1 invalid move, 10 solutions with two invalid moves, and so on.

**limitSearch** is the number of loser moves detected when the algorithm stops looking for all valid movements. For example if limitSearch=1 when the first invalid queen position is found the algorithm stops and try another solution, so, a limitSearch lower makes the algorithm faster.

Example output:
```
Is a valid solution!
Current board is (0) TOTAL(4764):
SolutionArray: 1,10,37,1
    01234567
0 - --o-----
1 - -----o--
2 - -o------
3 - ----o---
4 - -------o
5 - o-------
6 - ------o-
7 - ---o----
```


