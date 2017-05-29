var Main  =  Main || {};

Main.game = new Phaser.Game(900, 700, Phaser.AUTO, '');
localStorage.score = "";
localStorage.newGame = "true";
Main.game.state.add('Menu', Main.Menu);
Main.game.state.add('Game', Main.Game);
Main.game.state.start('Menu');


