var Main = Main || {};


Main.Game = function(){
    this.player = null;
    this.playerhealth = 2;
    this.playerHurt = false;
    this.healthBar = null;
    this.platforms = null;
    this.ground = null;
    this.bg = null;
    this.jumping = false;
    this.running = false;
    this.bgObjects = null;
    this.hurtObjects = null;
    this.timeCheck = 0;
    this.stars = null;
    this.spawnLocations_x = [];
    this.spawnLocations_y = [];
    this.score = 0;
    this.scoreText = null;
    this.checkStars = null;
};

Main.Game.prototype = {
    preload: function(){
        this.game.load.image('bg', 'assets/bg.png');
        this.game.load.image('ground', 'assets/stoneMid.png');
        this.game.load.image('sGround', 'assets/stoneHalf.png');
        this.game.load.image('lGround', 'assets/stoneHalfLeft.png');
        this.game.load.image('mGround', 'assets/stoneHalfMid.png');
        this.game.load.image('rGround', 'assets/stoneHalfRight.png');
        this.game.load.image('rGround', 'assets/stoneHalfRight.png');
        this.game.load.image('rock', 'assets/rock.png');
        this.game.load.image('pIcon', 'assets/hud_p3.png');
        this.game.load.image('spikes', 'assets/spikes.png');
        this.game.load.image('star', 'assets/star.png');
        this.game.load.image('hFull', 'assets/hud_heartFull.png');
        this.game.load.image('hHalf', 'assets/hud_heartHalf.png');
        this.game.load.image('hEmpty', 'assets/hud_heartEmpty.png');
        this.game.load.spritesheet('player', 'assets/walk.png', 72, 97);
        this.game.load.image('plant', 'assets/plantPurple.png', 70, 70);

        this.cursors = this.game.input.keyboard.createCursorKeys();

    },
    create: function(){
        //this.scale.scaleMode = Phaser.ScaleManager.SHOW_ALL;
        this.scale.pageAlignHorizontally = true;
        this.scale.pageAlignVertically = true;
        this.bg = this.game.add.sprite(0,0, 'bg');
        this.bg.width = 900;
        this.bg.height = 700;
        //this.game.stage.backgroundColor = '#cba0ff';

        this.game.physics.startSystem(Phaser.Physics.ARCADE);
        this.platforms = this.game.add.group();
        this.bgObjects = this.game.add.group();
        this.hurtObjects = this.game.add.group();
        this.stars = this.game.add.group();

        this.platforms.enableBody = true;
        //***************************************
        //*************PLATFORMS*****************
        //***************************************
        for(var x=0; x<=900; x+=70){
            this.platforms.create(x, this.game.world.height - 70, 'ground');
            if(x>= 210 && x<=420){
                if(x === 210){
                    this.platforms.create(x, this.game.world.height -230, 'lGround');
                }else if(x === 420){
                    this.platforms.create(x, this.game.world.height -230, 'rGround');
                }else{
                    this.platforms.create(x, this.game.world.height - 230, 'mGround');
                }
            }
            if(x === 70){
                this.platforms.create(x, this.game.world.height - 300, 'sGround');
            }
            if(x === 770){
                this.platforms.create(x, this.game.world.height - 450, 'sGround');
            }
            if(x>= 560 && x<=700){
                if(x === 560){
                    this.platforms.create(x, this.game.world.height - 320, 'lGround');
                } else if(x === 700){
                    this.platforms.create(x, this.game.world.height - 320, 'rGround');
                }else{
                    this.platforms.create(x, this.game.world.height - 320, 'mGround');
                }
            }
            if(x>= 280 && x<=350){
                if(x === 280){
                    this.platforms.create(x, this.game.world.height - 420, 'lGround');
                } else if(x === 350){
                    this.platforms.create(x, this.game.world.height - 420, 'rGround');
                }else{
                    this.platforms.create(x, this.game.world.height - 420, 'mGround');
                }
            }

            if(x>= 0 && x<=140){
                if(x === 0){
                    this.platforms.create(x, this.game.world.height - 550, 'lGround');
                } else if(x === 140){
                    this.platforms.create(x, this.game.world.height - 550, 'rGround');
                }else{
                    this.platforms.create(x, this.game.world.height - 550, 'mGround');
                }
            }
        }
        //***************************************
        //*************BG OBJECTS****************
        //***************************************
        this.bgObjects.create(230, this.game.world.height -295, 'plant');
        this.bgObjects.create(630, this.game.world.height -140, 'plant');
        this.bgObjects.create(700, this.game.world.height - 140, 'rock');
        //***************************************
        //*************HEALTH****************
        //***************************************
        this.healthBar = this.game.add.sprite(830, this.game.world.height - 680, 'hFull');
        this.bgObjects.create(770, this.game.world.height - 680, 'pIcon');
        this.platforms.setAll('body.immovable', true);
        //***************************************
        //***********HURTFUL OBJECTS*************
        //***************************************
        this.hurtObjects.enableBody = true;
        this.hurtObjects.create(610, this.game.world.height - 390, 'spikes');
        this.hurtObjects.forEach(function(element){
            element.body.setSize(70, 40, 0, 35);
        });
        this.hurtObjects.setAll('body.immovable', true);
        //***************************************
        //***************STARS*******************
        //***************************************

        var i = 0;
        this.platforms.forEach(function(element){
            this.spawnLocations_x[i] = element.body.x;
            this.spawnLocations_y[i] = element.body.y-70;
            i++;
        }, this);
        this.stars.enableBody = true;
        for(var i=0; i < 5; i++){
            var r = Math.floor((Math.random() * this.spawnLocations_x.length));
            this.stars.create(this.spawnLocations_x[r], this.spawnLocations_y[r], 'star');
        }
        this.stars.forEach(function(element){
            element.body.setSize(38, 32, 15, 20);
        });
        //***************************************
        //****************PLAYER*****************
        //***************************************
        this.player = this.game.add.sprite(0, this.game.world.height - 160, 'player');
        this.game.physics.arcade.enable(this.player);

        this.player.body.setSize(30, 87, 22, 5);

        this.player.body.bounce.y = 0.2;
        this.player.body.gravity.y = 350;
        this.player.body.collideWorldBounds = true;

        this.player.animations.add('stand', [1]);
        this.player.animations.add('hurt', [12]);
        this.player.animations.add('jump', [11]);
        this.player.animations.add('movement', [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);
        this.player.anchor.setTo(0.5, 0.5);

        //score
        this.scoreText = this.game.add.text(16, 16, 'score: 0', {fontSize: '26px', fontFamily: 'Arial', fill: '#fce5ff'});

    },

    update: function(){
        this.game.physics.arcade.collide(this.player, this.platforms);
        this.game.physics.arcade.overlap(this.player, this.stars, function(player, star){

            // Removes the star from the screen
            star.kill();
            this.stars.remove(star);
            this.score = Number(this.score) + 10;
            this.scoreText.setText('score: ' + this.score);
        }, null, this);
        this.game.physics.arcade.collide(this.player, this.hurtObjects, this.hurt, null, this);
        this.player.body.velocity.x = 0;

        if(this.player.body.touching.down){
            this.jumping = false;
        }

        if(this.cursors.left.isDown){
            this.running = true;
            this.player.body.velocity.x = -200;
            if(this.player.scale.x > 0){
                this.player.scale.x *= -1;
            }
            if(!this.playerHurt){
                this.player.animations.play('movement', 10, true);
            }
        } else if(this.cursors.right.isDown){
            this.running = true;
            this.player.body.velocity.x = 200;
            if(this.player.scale.x < 0){
                this.player.scale.x *= -1;
            }
            if(!this.playerHurt){
                this.player.animations.play('movement', 10, true);
            }
        }else{
            this.running = false;


        }
        if(this.cursors.up.isDown && this.player.body.touching.down){
            this.player.body.velocity.y = -350;
            this.jumping = true;

        }
        if(this.jumping) {
            this.player.animations.play('jump');
        }
        if(!this.running && !this.jumping && !this.playerHurt){
            this.player.animations.play('stand');
        }
        if(this.game.time.now - this.timeCheck > 2000 && this.playerHurt){
            this.playerHurt = false;
        }
        this.stateCheck();



    },

    hurt: function(player, spike){
        this.playerHurt = true;
        this.player.animations.play('hurt');
        this.timeCheck = this.game.time.now;
        player.body.velocity.x = -500;
        player.body.velocity.y = -500;
        this.playerhealth = Number(this.playerhealth) - 1;
    },

    stateCheck: function(){
        if(this.playerhealth === 2){
            this.healthBar.loadTexture('hFull');
        } else if(this.playerhealth === 1){
            this.healthBar.loadTexture('hHalf');
        } else{
            this.healthBar.loadTexture('hEmpty');
        }
        if(this.playerhealth == 0 || this.stars.length == 0){
            localStorage.score = this.score;
            this.shutdown();
        }
    },

    shutdown: function() {
        this.player = null;
        this.playerhealth = 2;
        this.playerHurt = false;
        this.healthBar = null;
        this.platforms = null;
        this.ground = null;
        this.bg = null;
        this.jumping = false;
        this.running = false;
        this.bgObjects = null;
        this.hurtObjects = null;
        this.timeCheck = 0;
        localStorage.newGame = "";
        this.score = 0;
        this.stars = null;
        this.spawnLocations_x = [];
        this.spawnLocations_y = [];
        this.game.state.start('Menu');
    }


    //collision boxes
    /*render: function(){
     this.game.debug.body(this.player);
     this.platforms.forEachAlive(this.renderGroup, this);
     this.hurtObjects.forEachAlive(this.renderGroup, this);
     this.stars.forEachAlive(this.renderGroup, this);
     },
     renderGroup: function(member){
     this.game.debug.body(member);
     }*/
};
