use std::path::Path;

use pun_analyse::{Project, run};

#[test]
fn narrows_non_pdo_exception_get_code_to_int() {
    let root = Path::new(env!("CARGO_MANIFEST_DIR")).join("tests/fixtures/exception-get-code");
    let mut project = Project::new(vec![root.join("cases.php")], Vec::new());
    project.php_version = pun_analyse::PhpVersion::from_id(80400);
    project.level = 9;
    let got: Vec<_> = run(&project)
        .unwrap()
        .into_iter()
        .map(|error| (error.line, error.identifier, error.message))
        .collect();
    let want: Vec<_> = [
        (58, "phpstan.dumpType", "Dumped type: (int|string)"),
        (59, "phpstan.dumpType", "Dumped type: (int|string)"),
        (60, "phpstan.dumpType", "Dumped type: (int|string)"),
        (61, "phpstan.dumpType", "Dumped type: int"),
        (62, "phpstan.dumpType", "Dumped type: int"),
        (63, "phpstan.dumpType", "Dumped type: int"),
        (64, "phpstan.dumpType", "Dumped type: (int|string)"),
        (65, "phpstan.dumpType", "Dumped type: (int|string)"),
        (66, "phpstan.dumpType", "Dumped type: int"),
        (67, "phpstan.dumpType", "Dumped type: string"),
        (68, "phpstan.dumpType", "Dumped type: string"),
        (69, "phpstan.dumpType", "Dumped type: int"),
        (70, "phpstan.dumpType", "Dumped type: (int|string)"),
        (71, "phpstan.dumpType", "Dumped type: (int|string)"),
        (72, "phpstan.dumpType", "Dumped type: int"),
        (
            81,
            "argument.type",
            "Parameter #1 $code of function ExceptionGetCode\\needsString expects string, int given.",
        ),
        (
            82,
            "argument.type",
            "Parameter #1 $code of function ExceptionGetCode\\needsString expects string, int given.",
        ),
    ]
    .into_iter()
    .map(|(line, id, message)| (line, id.to_owned(), message.to_owned()))
    .collect();
    assert_eq!(got, want);
}
