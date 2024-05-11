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
    const numberOfMines = 10;

    function createGameArray(rows, columns, numberOfMines) {
      var gameArray = new Array(rows);
      for (let i = 0; i < rows; i++) {
        gameArray[i] = new Array(columns).fill(null);
      }

      while (numberOfMines > 0) {
        var x = Math.floor(Math.random() * columns);
        var y = Math.floor(Math.random() * rows);

        if (gameArray[y][x] == null) {
          gameArray[y][x] = -1;


          var pos = {
            x: [-1, 1, 0, 0, 1, -1, 1, -1],
            y: [0, 0, -1, 1, 1, 1, -1, -1]
          }


          // y x - 1
          for (let count = 0; count < 8; count++) {
            if (y + pos.y[count] >= 0 && y + pos.y[count] < rows && x + pos.x[count] >= 0 && x + pos.x[count] < columns) {
              if (gameArray[y + pos.y[count]][x + pos.x[count]] == null || gameArray[y + pos.y[count]][x + pos.x[count]] != -1) {
                if (gameArray[y + pos.y[count]][x + pos.x[count]] != -1) {
                  gameArray[y + pos.y[count]][x + pos.x[count]] += 1;
                }
                else {
                  gameArray[y + pos.y[count]][x + pos.x[count]] = 1;
                }
              }
            }
          }

          numberOfMines--;
        }
      }

      gameArray[2][5] = -1;

      return gameArray;
    }

    //
    const gameArray = createGameArray(rows, columns, numberOfMines);

    function draw(gameArray) {
      let gameCells = '';

      gameArray.forEach((row, rowIdx) => {
        row.forEach((cell, colIdx) => {
          gameCells += `<div class="cell ${cell == -1 ? "bomb" : ''}" data-x="${colIdx}" data-y="${rowIdx}"></div>`
        })
      })

      $(".game-container").html(gameCells);
      $(".cell").css("width", `calc(${100 / columns}% - 2px)`);
    }
    draw(gameArray);


    $(".cell").on("click", (event) => {
      console.log(event.target.dataset.y, event.target.dataset.x);
      let x = event.target.dataset.x;
      let y = event.target.dataset.y;

      event.target.innerHTML = gameArray[y][x];
      console.log(event.target)
    })

  </script>
</body>

</html>