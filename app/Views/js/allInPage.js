/**
 * assign students to advisors
 * @author : Reynaldo
 */
 function assignStudents(){
  
  var selects = document.getElementsByTagName("select"), len = selects.length, i;
  for (i = 0; i < len; i++) {
    if (selects[i].id == "lowRange") {
        selects[i].value = selects[i].title;
    }else if (selects[i].id == "highRange") {
        selects[i].value = selects[i].title;
    }else if (selects[i].id == "majors") {
    	var values = selects[i].title.split(",");
    	var opts = selects[i].options;
    	
    	for (var p = 0; p < values.length; p++)
        {
            for (var j = 0; j < opts.length; j++)
            {
                if (opts[j].innerHTML == values[p] || opts[j].value == values[p])
                {
                    opts[j].selected = true;
                    
                }
            }
        }
    }else if(selects[i].id == "degree"){
    	var answers = selects[i].title.split(",");
    	var questions = selects[i].options;
    	
    	
    	for (var p = 0; p < answers.length; p++)
        {
            for (var j = 0; j < questions.length; j++)
            {
                if (questions[j].innerHTML == answers[p] || questions[j].value == answers[p])
                {
                    questions[j].selected = true;
                    
                }
            }
        }
    		
      }
	}
}
 
 /* end */
   