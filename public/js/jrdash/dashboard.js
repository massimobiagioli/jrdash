var Dashboard = function () {

    this.__construct = function () {
        console.log('Dashboard created');
        Template = new Template();
        Event = new Event();
        Result = new Result();
    };

    this.__construct();
};
