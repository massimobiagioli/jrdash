var Template = function() {
    
    this.__construct = function() {
        console.log('Template created');
    };
    
    this.todo = function(obj) {
        var output = '';
        output += '<div id="todo_' + obj.todo_id + '">';
        output += '<span>' + obj.content + '</span>';
        output += '<a href="#">Delete</a>';
        output += '</div>';
        return output;
    };
    
    this.note = function(obj) {
        var output = '';
        output += '<div id="note_' + obj.note_id + '">';
        output += '<span>' + note.title + '</span>';
        output += '<span>' + note.content + '</span>';
        output += '<a href="#">Delete</a>';
        output += '</div>';
        return output;
    };
    
    this.__construct();
};

