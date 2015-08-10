    <!-- CONTACT SECTION START -->
    <section id="contact" class="section">
        <div class="container section-wrapper">
            <div class="section-content">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h2 class="section-title uppercase">Contact Me</h2>
                    </div>
                    <!-- //.col-md-12 -->
                </div>
                <!-- //.row -->
                
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">

                        <!-- CONTACT FORM START -->
                        <form action="contact/send_mail.php" method="post" name="contact-form" id="contact-form" class="contact-form validate" role="form">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <div class="input-group input-group-lg">
                                            <div class="input-group input-group-lg">
                                                <input type="text" name="name" id="name" class="form-control required" placeholder="お名前" autocomplete="off">
                                            </div>
                                            <!-- //.input-group -->
                                        </div>
                                        <!-- //.input-group -->
                                    </div>
                                    <!-- //.form-group -->
                                    
                                    <div class="form-group">
                                        <label>サービス (オプション) :</label>

                                        <div class="checkbox">
                                            <input type="checkbox" name="services" id="itconsulting" value="ITコンサルティング">

                                            <label for="itconsulting">ITコンサルティング</label>
                                        </div>
                                        <!-- //.checkbox -->
                                        
                                        <div class="checkbox">
                                            <input type="checkbox" name="services" id="buildproject" value="プロジェクト構築">

                                            <label for="buildproject">プロジェクト構築</label>
                                        </div>
                                        <!-- //.checkbox -->

                                        <div class="checkbox">
                                            <input type="checkbox" name="services" id="projectmanage" value="プロジェクトマネージメント">

                                            <label for="projectmanage">プロジェクトマネージメント</label>
                                        </div>
                                        <!-- //.checkbox -->

                                        <div class="checkbox">
                                            <input type="checkbox" name="services" id="systemarchtect" value="システム設計">

                                            <label for="systemarchtect">システム設計</label>
                                        </div>
                                        <!-- //.checkbox -->
                                        
                                        <div class="checkbox">
                                            <input type="checkbox" name="services" id="systemdev" value="システム開発">

                                            <label for="systemdev">システム開発</label>
                                        </div>
                                        <!-- //.checkbox -->
                                        
                                        <div class="checkbox">
                                            <input type="checkbox" name="services" id="pmo" value="PMO">

                                            <label for="pmo">PMO</label>
                                        </div>
                                        <!-- //.checkbox -->
                                    </div>
                                    <!-- //.form-group -->
                                    
                                </div>
                                <!-- //.col-md-5 -->
                                
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <div class="input-group input-group-lg">
                                            <input type="email" name="email" id="email" class="form-control required email" placeholder="メールアドレス" autocomplete="off">
                                        </div>
                                        <!-- //.input-group -->
                                    </div>
                                    <!-- //.form-group -->
                                    
                                    <div class="form-group">
                                        <div class="input-group input-group-lg">
                                            <select name="subject" id="subject" class="select2 required" style="width: 100%">
                                                <option value="具体的なプロジェクトの相談">具体的なプロジェクトの相談</option>
                                                <option value="パートナーシップの相談">パートナーシップの相談</option>
                                                <option value="ご挨拶">ご挨拶</option>
                                                <option value="その他">その他</option>
                                            </select>
                                        </div>
                                        <!-- //.input-group -->
                                    </div>
                                    <!-- //.form-group -->
                                    
                                    <div class="form-group">
                                        <div class="input-group input-group-lg">
                                            <textarea name="message" id="message" class="form-control required" placeholder="メッセージ"></textarea>
                                        </div>
                                        <!-- //.input-group -->
                                    </div>
                                    <!-- //.form-group -->
                                </div>
                                <!-- //.col-md-7 -->
                            </div>
                            <!-- //.row -->

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button id="submit" type="button" onclick="webappobj.contact();">コンタクト</button>
                                    </div>
                                    <!-- //.form-group -->
                                </div>
                                <!-- //.col-md-12 -->
                            </div>
                            <!-- //.row -->
                        </form>
                        <!-- //CONTACT FORM END -->

                    </div>
                    <!-- //.col-md-8 -->
                </div>
                <!-- //.row -->
            </div>
            <!-- //.section-content -->
        </div>
        <!-- //.container -->
    </section>
    <!-- //CONTACT SECTION END -->
