var test= `
                                        //    ////*                             
                                       ////////    ///                          
                                      //////    ,///                            
                            ///      /////    *////      //,                    
                         ////      //////    //////    */                       
                       ///////  /////////   //////////////                      
                       ///////////*.//      //////////////  /                   
                       ///////....///       ////////////* /                     
                 .     /////......////     *////////      //                    
                 /     ////........,//////////../////.*/////////                
                //    ////.........@@(@@////.........../////////                
               //.   ////....#@@@@@(((((((((#@@@@@@@@@@@@@@/..//                
             ,*...////..@@@@@@@@(((((@@@@..................#@@@//               
           */........@@@...@@((((@@@.....@@@@@.................@@@              
          //.......@@,....@@(((@@....@@@@@@@@@@...@@@@@@@@@......%@@            
          /....(@@@@@@@@@@@((@@......@@@................@@@@%......@@@          
          /.@@@((((((((((((@@@............./,........,/,.............@@         
           @@(((((((((((((@@@..........@@@   @@@..@@@   @@@...........@@        
           #@@((((((((((((@@..........@@    @@ @@@@  @    @@...........@@       
             @@@@@(((((((@@..........,@@   @ @@ @@ @@ @@   @@...........@@      
            @@@@@@@@@@@@@@@...........@@   @@@@ @@*%@@@/  ,@@............@@     
           .@@@@#########@@...........@@@      @@@@       @@.............@@     
           @@@@@@@@@@@@@@@@.............@@@@@@@(...@@@@@@@...............@@     
        @@((((((((((((((@@..................................@@...........@@     
       @(((((((((((((((@@@............@@@@@...........%@@@@@@............@@     
        @((((((((((((((@@@.............@@@  (@@@@@@@%   @@@..............@@     
          @@@.@@@@@@@((@@...............%@@           @@@...........@@@@@,      
       @@@............@@,.................@@@      @@@@.......@@@@@%            
      @@@@@@@@@@@@@@.%@@....................#@@@@@@....@@@@@@                   
         @@..@@@@@@@@@@........................@@@@@@@                          
          @@.@@@@@@@@.................*@@@@@@@                                  
           @@(..............%@@@@@@@@                                           
             .@@@@@@@@@@@@*\n`;
	$(function(){
		$(".element").typed({
            strings: ['\nLooking for bunker.......\n\n\nAligning satellites...\n\n\n'+test+'Location Found!\n\n\nStored image at /{location_name}.png'],
            typeSpeed: -10,
            backSpeed: 0,
            loop: false
		});
	});
    setTimeout(() => { console.log("Location at : 13.399152, 144.663735"); }, 30000);