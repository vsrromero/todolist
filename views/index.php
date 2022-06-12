<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>
    <header>
        <div class="top"><h1>My To Do List</h1></div>
    </header>

    <main>

        <section>

            <div class="left">
                <div class="title">
                    Create your task
                </div>

                <div class="mForm">
                    <div class="mFormLeft">
                        Task Author: <br />
                        Task: <br />
                        Description: <br />
                        Comments: <br />
                    </div>
                    <div class="mFormRight">
                            <form action="">
                                <input name="task_author" type="text" size="30" placeholder="Task author"> <br />
                                <input name="task_name" type="text" size="30" placeholder="My task"> <br />
                                <input name="task_description" type="text" size="30" placeholder="What is your task about?"> <br />
                                <textarea name="comments" rows="10" cols="50" placeholder="Further comments about your task, how to do it, when, why, etc..."></textarea>
                            </form>
                        </div>
                </div>
            </div>

            <div class="right">

                <div class="title">
                    Tasks Summary
                </div>

                <div class="tasksSummary">
                    <div class="tasksTitles">
                        Tasks To do: <br />
                        Tasks Doing: <br />
                        Tasks Done: <br />
                    </div>
                    <div class="tasksData">
                         0 <br />
                         0 <br />
                         0 <br />
                    </div>
                </div>

            </div>

        </section>

        <section>

            <div class="bottomMain">
                Tasks Created
            </div>

        </section>
    </main>

    <footer>
        <div class="bottom">footer</div>
    </footer>
</body>
</html>
