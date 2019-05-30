const gpio = require('onoff').Gpio;

var sem1Verde = new gpio(6, 'out');

sem1Verde.writeSync(1);
