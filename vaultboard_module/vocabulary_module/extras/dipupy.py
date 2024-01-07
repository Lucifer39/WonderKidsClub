import pandas as pd

class datatocsv:
    def __init__(self,text_file_path,csv_file_path):
        self.path=text_file_path
        self.csv_path=csv_file_path
        
    def test_function(self):
        file_obj= open(self.path,"r")
        text_list = file_obj.readlines()

        feature_list=["Meaning","Antonyms","Synonyms","Example"]
        dict_fn={"Word":[],"Meaning":[],"Antonyms":[],"Synonyms":[],"Example":[]}
        print(text_list)
        print(len(text_list))
        for tx in text_list:
            check=0
            for fn in feature_list:
                if(tx.find(fn)!=-1):
                    s=tx.split(":")[1].replace(r"\n","").strip()
                    dict_fn[fn].append(s)
                    check=1
                    break
            if(check==0):
                s=tx.replace(r"\n","").strip()
                dict_fn["Word"].append(s)
        #print(dict_fn)
        for k in dict_fn.keys():
            print(len(dict_fn[k]))

        df = pd.DataFrame.from_dict(dict_fn)
        df.to_csv(self.csv_path)
        print("success")

if __name__=="__main__":
    res=datatocsv("dictionary.txt","result.csv")
    res.test_function()