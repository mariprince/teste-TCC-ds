const express = require("express");
const dotenv = require("dotenv");
const { createClient } = require("@supabase/supabase-js");
const bodyParser = require("body-parser")
const cookieParser = require("cookie-parser");
const path = require("path");
const fs = require("fs");

dotenv.config();
const app = express();
const PORT = 3000;

const supabase = createClient(process.env.SUPABASE_URL, process.env.SUPABASE_KEY);

app.use(bodyParser.urlencoded({ extended: true }));
app.use(cookieParser());
app.use(express.static("public"));

app.get("/", (req, res) => {
    res.sendFile(path.join(__dirname, "public", "index.html"));
});

app.post("/cadastro", async (req, res) => {
    const { email, password } = req.body;
    const { user, error } = await supabase.auth.signUp({ email, password });

    if (error) return res.redirect(`/error.html?`)
});

app.post("/login", async (req , res) => {
    const { email, password } = req.body;
    const { data, error } = await supabase.auth.signInWithPassword({ email, password });

    res.cookie("acess_token", data.session.access_token, { httpOnly: true});
    res.redirect("/index");
});

app.get("/private", async (req, res) => {
    const token = req.cookies.acess_token;
    if (!token) return res.redirect("/");

    const { data, error } = await supabase.auth.getUser(token);
    if (error) return res.redirect("/")
    
        const filePath = path.join(__dirname, "private.html");

    fs.readFile(filePath, "utf8", (err, html) => {
        if (err) {
            console.error("Error: private.html could not be loaded!", err);
            return res.status(500).send("Server error: private.html not found. ");
        }

        const modifiedHtml = html.replace("{{userEmail}}", data.user.email);
        res.send(modifiedHtml);
    });
});

app.get("/logout", (req, res) => {
    res.clearCookie("access_token");
    res.redirect("/");
});
document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("formCadastroMotorista");

  form.addEventListener("submit", async (event) => {
    event.preventDefault(); // impede que o formulário recarregue a página

    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;

    try {
      const response = await fetch("/cadastro", {
        method: "POST",
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify({ email, password })
      });

      if (response.ok) {
        // Redireciona para página de sucesso ou login
        window.location.href = "/login.html";
      } else {
        // Redireciona para página de erro
        window.location.href = "/error.html";
      }
    } catch (error) {
      console.error("Erro no cadastro:", error);
      window.location.href = "/error.html";
    }
  });
});


app.listen(PORT, () => console.log(`Server running on http://localhost:${PORT}`));