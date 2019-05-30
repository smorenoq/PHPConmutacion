const gpio = require('onoff').Gpio;

var sem1Verde = new gpio(2, 'out');

sem1Verde.writeSync(1);
