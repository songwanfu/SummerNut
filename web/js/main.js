function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function validateUsername(username) {
	if (username.length > 3 && username.length < 16) {
		return true;
	}
	return false;
}

function validateSignature(signature) {
	if (signature == null || signature.length < 255 ) {
		return true;
	}
	return false;
}

function headPicList() {
	return new Array(
		'',
		'http://img.mukewang.com//533e4d7c0001828702000200.jpg',
		'http://img.mukewang.com//533e4d5b0001d57502200203.jpg',
		'http://img.mukewang.com//545866130001bfcb02200220.jpg',
		'http://img.mukewang.com//5458626a0001503602200220.jpg',
		'http://img.mukewang.com//545865b90001b1d102200220.jpg',
		'http://img.mukewang.com//545865c30001a2d802200220.jpg',
		'http://img.mukewang.com//545868aa0001fe0502200220.jpg',
		'http://img.mukewang.com//54584d1300016b9b02200220.jpg',
		'http://img.mukewang.com//545865e60001de0902200220.jpg',
		'http://img.mukewang.com//545846580001fede02200220.jpg',
		'http://img.mukewang.com//545869510001a20b02200220.jpg',
		'http://img.mukewang.com//5458662500019a7c02200220.jpg',
		'http://img.mukewang.com//545863080001255902200220.jpg',
		'http://img.mukewang.com//5458689200016e1802200220.jpg',
		'http://img.mukewang.com//5458475800015cb202200220.jpg',
		'http://img.mukewang.com//54584f8f00019fc002200220.jpg',
		'http://img.mukewang.com//5458674e0001e87402200220.jpg',
		'http://img.mukewang.com//54584c86000151a502200220.jpg',
		'http://img.mukewang.com//54584f7b0001559202200220.jpg',
		'http://img.mukewang.com//545850ee0001798a02200220.jpg',
		'http://img.mukewang.com//545863aa00014aa802200220.jpg',
		'http://img.mukewang.com//5458687b0001189602200220.jpg',
		'http://img.mukewang.com//533e4caf0001fac402000200.jpg',
		'http://img.mukewang.com//5458463b0001358f02200220.jpg',
		'http://img.mukewang.com//545846160001674602200220.jpg',
		'http://img.mukewang.com//5458639d0001bed702200220.jpg',
		'http://img.mukewang.com//533e4c640001354402000200.jpg',
		'http://img.mukewang.com//54584f850001c0bc02200220.jpg',
		'http://img.mukewang.com//533e51840001ca2502000200.jpg',
		'http://img.mukewang.com//5333a0aa000121d702000200.jpg',
		'http://img.mukewang.com//533e4c420001b2e502000200.jpg',
		'http://img.mukewang.com//545861f00001be3402200220.jpg',
		'http://img.mukewang.com//545862fe00017c2602200220.jpg',
		'http://img.mukewang.com//545846230001832502200220.jpg',
		'http://img.mukewang.com//5333a0f60001eaa802200220.jpg',
		'http://img.mukewang.com//5458476500014e6402200220.jpg',
		'http://img.mukewang.com//545865da00012e6402200220.jpg',
		'http://img.mukewang.com//5458458d000181e402200220.jpg',
		'http://img.mukewang.com//5458643d0001a93c02200220.jpg',
		'http://img.mukewang.com//54586849000122fd02200220.jpg',
		'http://img.mukewang.com//545868cd00013bbb02200220.jpg',
		'http://img.mukewang.com//545846580001fede02200220.jpg',
		'http://img.mukewang.com//5333a0d9000196ff02000200.jpg',
		'http://img.mukewang.com//545861c80001141e02200220.jpg',
		'http://img.mukewang.com//5458506b0001de5502200220.jpg',
		'http://img.mukewang.com//5458456b0001812002200220.jpg',
		'http://img.mukewang.com//545868b60001587202200220.jpg',
		'http://img.mukewang.com//54584dc4000118d302200220.jpg',
		'http://img.mukewang.com//54584e460001e2dc02200220.jpg',
		'http://img.mukewang.com//54584c9c0001489602200220.jpg'
	);
}


