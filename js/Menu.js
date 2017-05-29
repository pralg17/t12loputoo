var Main = Main || {};

Main.Menu = function(){
    this.menuText = null;
    this.scoreText = null;
};

Main.Menu.prototype = {
    preload: function(){
        this.game.stage.backgroundColor = '#cba0ff';
    },

    create: function(){
        this.scale.pageAlignHorizontally = true;
        this.scale.pageAlignVertically = true;
        if(localStorage.newGame === "true"){
            this.menuText = this.game.add.text(this.game.world.width / 2.1,this.game.world.height / 2, 'Play',
                {fontSize: '26px', fill: '#ffffff'});
        } else{
            this.scoreText = this.game.add.text(this.game.world.width / 2.8, this.game.world.height / 2.5, 'Your score was: ' + localStorage.score,
                {fontSize: '26px', fill: '#ffffff'});
            this.menuText = this.game.add.text(this.game.world.width / 2.4,this.game.world.height / 2, 'Play again',
                {fontSize: '26px', fill: '#ffffff'});
        }
        this.menuText.inputEnabled = true;
        this.menuText.events.onInputDown.add(this.down, this);
    },

    down: function(text){
        this.game.state.start('Game');
    }

};

