const gpio = require('onoff').Gpio;

var sem1Verde = new gpio(3, 'out');

sem1Verde.writeSync(0);
