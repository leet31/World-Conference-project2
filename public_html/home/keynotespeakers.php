<!doctype html>
<html><head>
        <meta charset="utf-8">
        <title>Keynote Speakers</title>
        <style>
            ul {
                list-style-type: none;
                margin: 0;
                padding: 0;
                overflow: hidden;
                background-color: #171515;

            }
            li  {
                 float: left;
                 border-right:1px solid #bbb;
            }

            li:last-child {
                 border-right: none;
            }
            li a, .dropbtn { 
                display: inline-block;
                color: white;
                text-align: center;
                padding: 20px;
                text-decoration: none;
            }

            li a:hover, .dropdown:hover .dropbtn {
                background-color: red;		
            }

            li.dropdown {
                display: inline-block;
            }

            .dropdown-content {
                display: none;
                position: absolute;
                background-color: #f9f9f9;
                min-width: 160px;
                box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            }

            .dropdown-content a {
                color: black;
                padding: 20px;
                text-decoration: none;
                display: block;
                text-align: left;
            }

            .dropdown-content a:hover {background-color: #f1f1f1}

            .dropdown:hover .dropdown-content {
                display: block;
            }
            .container{
        overflow:hidden;
        width:300px;/*change this to whatever you want*/
        height:150px;/*change this to whatever you want*/

        /*Of course, to get the desired effect, the size of the image "<img>" below must be larger than the size mentioned above*/
    }

    .container:hover{
        overflow:visible
    }
        </style>
    </head>

    <body bgcolor="#4880D5">
        
        <div id="menu">
            <p style="text-align: center; font-family: Baskerville, 'Palatino Linotype', Palatino, 'Century Schoolbook L', 'Times New Roman', serif; font-style: oblique; font-size: x-large;">Keynote Speakers</p>
            <?php echo(file_get_contents('.\menu.html')) ?>
            
        </div>
             <div class='container'><img src="../images/download.jpe"/></div>
               <div
                <p style="text-align: left; font-family: Baskerville, 'Palatino Linotype', Palatino, 'Century Schoolbook L', 'Times New Roman', serif; font-style: normal; font-size: 14px;"><span style="color: rgba(255,255,255,1)">Grady Booch is an American software engineer best known for developing the UML (Unified Modeling Language) with Ivar Jacbson and James Rumbaugh. He is recognized internationally for his innovative work in software architecture, software engineering, and collaborative development. </span></p>
                <p style="text-align: left; font-family: Baskerville, 'Palatino Linotype', Palatino, 'Century Schoolbook L', 'Times New Roman', serif; font-style: normal; font-size: 14px;">Topic of Discussion: <span style="font-style: normal; font-weight: bolder;">Software engineering</span>. &quot;Each Phase is the insurance of achievements towards success&quot;</p>
               </div>
        </div>

        <div id="note2">
            <div class="dropdown2">
                <img src="../images/Troy_Hunt.jpg" width="118" height="124" alt=""/>
                <p style="text-align: right; font-family: Baskerville, 'Palatino Linotype', Palatino, 'Century Schoolbook L', 'Times New Roman', serif; font-style: normal; font-size: 14px;"><span style="color: rgba(255,255,255,1)">Troy Hunt is an Australian web security expert. He is the creator of ASafaWeb, a tool that performs automated security analysis on ASP.NET websites. Hunt was named a Microsoft Most Valuable Professional (MVP) in Developer Security, and was recognized as a Microsoft MVP of the Year in 2011. He was also named a Microsoft Regional Director in 2016. </span></p>
                <p style="text-align: left; font-family: Baskerville, 'Palatino Linotype', Palatino, 'Century Schoolbook L', 'Times New Roman', serif; font-style: normal; font-size: 14px;">Topic of Discussion:  <span style="font-style: normal; font-weight: bolder;">Computer Security</span>. &quot;Security, how far is to negligent&quot; </p>
                <div class="dropdown-content2">
                    <img src="../images/Troy_Hunt.jpg" alt="" width="250" height="200">
                </div>
            </div>
        </div>

        <div id="note3">
            <div class="dropdown2">
                <img src="../images/Wertheimer-Jeremy_250.jpg" width="131" height="146" alt=""/>
                <p style="text-align: left; font-family: Baskerville, 'Palatino Linotype', Palatino, 'Century Schoolbook L', 'Times New Roman', serif; font-style: normal; font-size: 14px;"><span style="color: rgba(255,255,255,1)">Jeremy Wertheimer founded and served as the CEO od ITA Software, a 400+ person software company based in Cambridge, MA, that powers the airfare searches on the websites of American Airlines, United Airlines, Southwest Airlines, US Airways, Orbitz, Kayak, Howire et al. Google acquired ITA Software in 2011. Jeremy is now the VP for Travel at Google. He is a trustee of Massachusetts Technology Leadership COuncil and a trustee of Maimonides school in Brookline, MA. He received a BE in Electrical Engineering from Cooper Union in 1982, an SM from MIT in COmputer Science, and PhD from MIT in Artificial Intelligence, with a minor in Neuroscience. </span></p>
                <p style="text-align: left; font-family: Baskerville, 'Palatino Linotype', Palatino, 'Century Schoolbook L', 'Times New Roman', serif; font-style: normal; font-size: 14px;">Topic of Discussion: <span style="font-style: normal; font-weight: bolder;">Artificial Intelligence</span>. &quot;Where does humanity stand against artifical intelligence?&quot;</p>
                <div class="dropdown-content2">
                    <img src="../images/Wertheimer-Jeremy_250.jpg" alt="" width="250" height="200">
                </div>

                <div id="note4">
                    <div class="dropdown2">
                        <img src="../images/susan-kare-300.jpg" width="126" height="141" alt=""/>
                        <p style="text-align: left; font-family: Baskerville, 'Palatino Linotype', Palatino, 'Century Schoolbook L', 'Times New Roman', serif; font-style: normal; font-size: 14px;"><span style="color: rgba(255,255,255,1)">Susan Kare, a designer who helped bring the Apple computer to life with her sophiscated typography and iconic graphic skills. Working alongside Steve Jobs, she shaped many of the now-common interface elements of the Mac, like the command icon, which she found while looking through a book of symbols. </span></p>
                        <p style="text-align: left; font-family: Baskerville, 'Palatino Linotype', Palatino, 'Century Schoolbook L', 'Times New Roman', serif; font-style: normal; font-size: 14px;">Topic of Discussion: <span style="font-style: normal; font-weight: bolder;">Mobile Computing</span>. &quot;Mobile it shapes the way we evolve communications and intelligence.&quot;</p>
                        <div class="dropdown-content2">
                            <img src="../images/susan-kare-300.jpg" alt="" width="250" height="200">
                        </div>

                        <div id="note5">
                            <div class="dropdown2">
                                <img src="../images/stanislaw_raczynski_gawin.jpg" width="128" height="125" alt=""/>
                                <p style="text-align: left; font-family: Baskerville, 'Palatino Linotype', Palatino, 'Century Schoolbook L', 'Times New Roman', serif; font-style: normal; font-size: 14px;"><span style="color: rgba(255,255,255,1)">Grady Booch is an Americ<strong>Stanislaw Raczynski</strong> is a professor of control theory, electronics and computer simulation at the Panamerican University in Mexico City. He is also the international director of the Socirty for Modelling Simulation in San Diego. He has authored 1 book, &ldquo;Simulacion por computadora&rdquo; and over 70 journal articles &amp; conference papers.an software engineer best known for developing the UML (Unified Modeling Language) with Ivar Jacbson and James Rumbaugh. He is recognized internationally for his innovative work in software architecture, software engineering, and collaborative development. </span></p>
                                <p style="text-align: left; font-family: Baskerville, 'Palatino Linotype', Palatino, 'Century Schoolbook L', 'Times New Roman', serif; font-style: normal; font-size: 14px;">Topic of Discussion: <span style="font-style: normal; font-weight: normal;"><span style="font-weight: bold">Simulation and Modeling.</span> &quot;Where do we go from here?&quot;</span> </p>
                                <div class="dropdown-content2">
                                    <img src="../images/stanislaw_raczynski_gawin.jpg" width="250" height="200">
                                </div>
                            </div>
                            </table>
                            </body>
                            </html>
