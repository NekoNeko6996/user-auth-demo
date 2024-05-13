<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/minesweeper.css">
  <script src="../../libraries/jquery.min.js"></script>
  <title>Minesweeper</title>
</head>

<?php

?>

<body>
  <div class="game-container">

  </div>



  <script>
    const rows = 10;
    const columns = 10;
    const numberOfMines = 15;

    function createGameArray(rows, columns, numberOfMines) {
      var gameArray = new Array(rows);

      for (let i = 0; i < rows; i++) {
        gameArray[i] = new Array(columns);
        for (let j = 0; j < columns; j++) {
          gameArray[i][j] = {
            isBomb: false,
            isOpened: false,
            isFlag: false,
            value: 0
          };
        }
      }


      while (numberOfMines > 0) {
        var x = Math.floor(Math.random() * columns);
        var y = Math.floor(Math.random() * rows);

        if (!gameArray[y][x].isBomb) {
          gameArray[y][x].isBomb = true;


          var pos = {
            x: [-1, 1, 0, 0, 1, -1, 1, -1],
            y: [0, 0, -1, 1, 1, 1, -1, -1]
          }


          // y x - 1
          for (let count = 0; count < 8; count++) {
            if (y + pos.y[count] >= 0 && y + pos.y[count] < rows && x + pos.x[count] >= 0 && x + pos.x[count] < columns) {
              if (!gameArray[y + pos.y[count]][x + pos.x[count]].isBomb) {
                gameArray[y + pos.y[count]][x + pos.x[count]].value += 1;
              }
            }
          }

          numberOfMines--;
        }
      }
      return gameArray;
    }


    //
    function openAdjacentCells(row, col) {
      row = parseInt(row);
      col = parseInt(col);

      if (row < 0 || row >= rows || col < 0 || col >= columns) {
        return;
      }
      if (gameArray[row][col].isOpened || gameArray[row][col].isBomb) {
        return;
      }

      if (gameArray[row][col].value > 0) {
        gameArray[row][col].isOpened = true;
        $(`.cell[data-x="${col}"][data-y="${row}"]`).text(gameArray[row][col].value);
        return;
      }

      gameArray[row][col].isOpened = true;

      $(`.cell[data-x="${col}"][data-y="${row}"]`).css("background-color", "rgba(76, 255, 85, 0.822)");

      if (gameArray[row][col].value == 0) {
        openAdjacentCells(row - 1, col - 1);
        openAdjacentCells(row - 1, col);
        openAdjacentCells(row - 1, col + 1);
        openAdjacentCells(row, col - 1);
        openAdjacentCells(row, col + 1);
        openAdjacentCells(row + 1, col - 1);
        openAdjacentCells(row + 1, col);
        openAdjacentCells(row + 1, col + 1);
      }
    }


    //
    var flag = numberOfMines;
    var flagOnMines = numberOfMines;

    $(document).ready(() => {
      $(".cell").contextmenu((event) => {
        event.preventDefault();

        let x = event.target.dataset.x;
        let y = event.target.dataset.y;

        if (gameArray[y][x].isOpened) {
          return;
        }

        gameArray[y][x].isFlag = !gameArray[y][x].isFlag;
        if (gameArray[y][x].isFlag) {
          $(`.cell[data-x="${x}"][data-y="${y}"]`).css("background-color", "red");
          if (gameArray[y][x].isBomb) {
            flagOnMines--;
          }
          flag--;

          if (flagOnMines == 0) {
            alert("you won");
          }
        } else {
          $(`.cell[data-x="${x}"][data-y="${y}"]`).css("background-color", "white");
          if (gameArray[y][x].isBomb) {
            flagOnMines++;
          }
          flag++;
        }
      })
    })



    //
    const gameArray = createGameArray(rows, columns, numberOfMines);

    function draw(gameArray) {
      let gameCells = '';

      gameArray.forEach((row, rowIdx) => {
        row.forEach((cell, colIdx) => {
          gameCells += `<div class="cell" data-x="${colIdx}" data-y="${rowIdx}"></div>`
        })
      })

      $(".game-container").html(gameCells);
      $(".cell").css("width", `${100 / columns}%`);
    }
    draw(gameArray);


    $(".cell").on("click", (event) => {
      console.log(event.target.dataset.y, event.target.dataset.x);
      let x = event.target.dataset.x;
      let y = event.target.dataset.y;

      if (gameArray[y][x].isOpened) {
        return;
      }

      if (gameArray[y][x].isBomb) {
        alert("you lost");
      }

      openAdjacentCells(y, x);
    })

  </script>
</body>

</html>