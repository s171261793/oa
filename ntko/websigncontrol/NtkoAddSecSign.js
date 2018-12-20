//ע��:�����ڲ���Ҫʹ�õĺ�������
//ocxElement.codebase = "ntkoWebSign.cab#version=4,0,2,1";
//�����Ը�����Ҫ�޸�֮�⣬������䲻Ҫ�޸�
function NtkoReserved_AddSecSignOcx(ControlID,ocxLeft,ocxTop)
{
	var ocxElement = null;
	try
	{
		ocxElement = document.createElement('object');
		if("string" == typeof(ControlID))
		{
			ocxElement.id = ControlID;
		}
		ocxElement.style.position = "absolute";
		ocxElement.style.pixelLeft = ocxLeft;
		ocxElement.style.pixelTop = ocxTop;
		ocxElement.codebase = "websigncontrol/ntkoWebSign.cab#version=4,0,2,1";
		ocxElement.classid = "clsid:AA4B3728-B61C-4bcc-AEE7-0AA47D3C0DDA"; 
		ocxElement.width = "10";
		ocxElement.height = "10";
		document.body.appendChild(ocxElement);	
		return ocxElement;
	}
	catch(err)
	{		
		alert("ӡ�¶���װ�ش���!��ȷ������ȷ��װ��NTKO��ȫ����ӡ��ϵͳ��"+ err.number + ":" + err.description);			
		if(ocxElement)
		{
			obj.Close();
			ocxElement.removeNode();
		}
	}
	return null;
}

function NtkoReserved_DeleteMe(ocxElement){

	if(null==ocxElement) return;
	if(ocxElement.classid != "clsid:AA4B3728-B61C-4bcc-AEE7-0AA47D3C0DDA")
		return;
		
	ocxElement.Close();
	ocxElement.removeNode();
}

//ע�⣺���º�������ʾ��Ϣ֮�⣬������䲻Ҫ�޸ġ�
function NtkoReserved_RunSignHelper(ocxElement,UserName,FileName,PromptSelect,
		PrintMode,IsUseCertificate,IsLocked,IsCheckDocChange,
		IsShowUI,SignPass,SignType,IsAddComment,AdjustToHeight,SignIndex)
{
	if("object" != typeof(ocxElement)) return;
	ocxElement.SetUser(UserName);
	switch(SignType)
	{
		case 0:
			{
				try
				{
					ocxElement.DoSign(FileName,PromptSelect, SignPass, PrintMode, 
						IsUseCertificate, IsLocked,IsCheckDocChange,IsShowUI,IsAddComment);
				}
				catch(err)
				{		
					alert("�Ӹ�ӡ�´���!");			
					ocxElement.Close();
					ocxElement.removeNode();
				}
			}
			break;
		case 1:
			{
				try
				{
					ocxElement.DoHandSign(PrintMode,IsUseCertificate,IsLocked,IsCheckDocChange,
						IsShowUI,SignPass,IsAddComment,AdjustToHeight);
				}
				catch(err)
				{
					alert("��дǩ������!");
					ocxElement.Close();
					ocxElement.removeNode();
				}		
			}	
			break;
		case 2:
			{
				try
				{
					ocxElement.DoSignFromEkey(SignPass,PrintMode,IsUseCertificate,IsLocked,
						IsCheckDocChange,IsShowUI,SignIndex,IsAddComment);
				}
				catch(err)
				{
					alert("�Ӹ�EKEYӡ�´���!");
					ocxElement.Close();
					ocxElement.removeNode();
				}		
			}	
			break;	
		case 3:
			{
				try
				{
					ocxElement.DoKeyBoardComment(PrintMode,IsUseCertificate,IsLocked,IsCheckDocChange,IsShowUI,SignPass);
				}
				catch(err)
				{
					alert("��Ӱ�ȫ������ע����!");
					ocxElement.Close();
					ocxElement.removeNode();
				}		
			}	
			break;		
		case 4:
			{
				try
				{
					ocxElement.DoHandSignFullScreen(PrintMode,IsUseCertificate,IsLocked,IsCheckDocChange,
						IsShowUI,SignPass,IsAddComment,AdjustToHeight);
				}
				catch(err)
				{
					alert("ȫ����дǩ������!");
					ocxElement.Close();
					ocxElement.removeNode();
				}			
			}	
			break;			
		case 5:
			{
				try
				{
					ocxElement.DoHandSignInplace(PrintMode,IsUseCertificate,IsLocked,IsCheckDocChange,
						IsShowUI,SignPass);
				}
				catch(err)
				{
					alert("Ƕ����дǩ������!");
					ocxElement.Close();
					ocxElement.removeNode();
				}			
			}	
			break;					
		default: 
			{
				try
				{
					ocxElement.DoSign(FileName,true, SignPass, PrintMode, 
						IsUseCertificate, IsLocked,IsCheckDocChange,IsShowUI);
				}
				catch(err)
				{
					alert("�Ӹ�ӡ�´���!");
					ocxElement.Close();
					ocxElement.removeNode();
				}					
			}
			break;	
	}
}