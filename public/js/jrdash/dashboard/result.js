var Result = function () {

    this.__construct = function () {
        console.log('Result created');
    };
    
    var success = function() {
        console.log('success');
    };
    
    var error = function() {
        console.log('error');
    };
    
    this.__construct();
};

